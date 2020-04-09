<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Settings;
use App\Agents;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public $AGENT_TYPE  = 1;
    public $LENDER_TYPE = 2;
    public $LAWYER_TYPE = 3;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Client part start

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $agents = Agents::all()->sortBy("name");

        return view('dashboard', array(
            'activeMenu' => 'clients',
            'agents' => $agents
        ));
    }

    public function clientsData(Request $request)
    {

        $model = new Clients();
        $filter['status'] = $request->input('filter_status');
        $filter['agent_id'] = $request->input('agent_id');
        $filter['lender_id'] = $request->input('lender_id');
        $filter['lawyer_id'] = $request->input('lawyer_id');

        if (isset($request->input('search')['value']) && $request->input('search')['value'] != '') {
            $filter['search'] = $request->input('search')['value'];
        }

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir')
        );

        return response()->json([
            'data' => $items['data'],
            'recordsFiltered' => $items['count'],
            'recordsTotal' => $items['count']
        ]);

    }

    public function getClient(Request $request)
    {
        $id = $request->input('client_id', false);
        $client = $id && $id != 'false' ? Clients::find($id) : false;
        $fees = null;
        if ($client) {
            $fees = unserialize($client->settings);
        }

        $agents = Agents::all();

        return view('client_popup', array('client' => $client, 'fees' => $fees, 'agents' => $agents));
    }

    public function saveClient(Request $request)
    {
        $data = $request->all();

        $clientId = $data['client_id'] ?? null;

        $validations = array(
            'name' => 'required|string',
        );
        $validator = Validator::make($data, $validations);

        if ($validator->fails()) {
            $html = "<div>";
            foreach ($validator->errors()->all() as $error) {
                $html .= "<span>" . $error . "</span>";
            }
            $html .= "</div>";
            return response()->json([
                'status' => 0,
                'errors' => $html
            ]);
        }

        if ($clientId && $clientId != 0) {
            $client = Clients::find($clientId);
        } else {
            $client = new Clients();
        }

        $client->name = $data['name'];
        $client->email = $data['email'];
        $client->dob = $data['dob'];
        $client->phone = $data['phone'];
        $client->status = $data['status'];
        $client->iad = $data['iad'];

        if ($data['iad']) {
            $client->renewal_date = $this->getRenewalDate($client->iad, $data['term']);
//            $client->iad = $this->getRenewalDate($client->iad);
        }

        $agentId  = $data['agent_id']  ?? null;
        $lenderId = $data['lender_id'] ?? null;
        $lawyerId = $data['lawyer_id'] ?? null;

        if ($agentId === '-1') {
            $newAgent = Agents::create(['name' => $data['agent_name'],
                'phone' => $data['agent_phone'],
                'email' => $data['agent_email'],
                'type'  => $this->AGENT_TYPE
            ]);

            $client->agent_id = $newAgent->id;
        } else {
            $client->agent_id = $agentId;
        }

        // add lender
        if ($lenderId === '-1') {
            $newAgent = Agents::create(['name' => $data['lender_name'],
                'phone' => $data['lender_phone'],
                'email' => $data['lender_email'],
                'type'  => $this->LENDER_TYPE]);

            $client->lender_id = $newAgent->id;
        } else {
            $client->lender_id = $lenderId;
        }

        // add lawyer
        if ($lawyerId === '-1') {
            $newAgent = Agents::create(['name' => $data['lawyer_name'],
                'phone' => $data['lawyer_phone'],
                'email' => $data['lawyer_email'],
                'type'  => $this->LAWYER_TYPE,
            ]);

            $client->lawyer_id = $newAgent->id;
        } else {
            $client->lawyer_id = $lawyerId;
        }

        $settings['mortgage']   = array('fee' => $data['mortgage_fee']);
        $settings['broker']     = array('fee' => $data['broker_fee']);
        $settings['lender']     = array('fee' => $data['lender_fee']);
        $settings['admin']      = array('fee' => $data['admin_fee']);
        $settings['lawyer']     = array('fee' => $data['lawyer_fee']);
        $settings['estimated']  = array('fee' => $data['estimated_fee']);
        $settings['appraisal']  = array('fee' => $data['appraisal_fee']);

        $settings = serialize($settings);
        $client->settings = $settings;

        $client->co_signor = (isset($data['co_signor']) && count($data['co_signor']) > 0) ? json_encode($data['co_signor'], JSON_FORCE_OBJECT) : null;
        $client->legal_pid = $data['legal_pid'];
        $client->mailing_address = $data['mailing_address'];

        $securityArr = [];
        foreach ($data['property_security'] as $key =>$val) {
            $securityArr[$key]['property_security'] = $val;
            $securityArr[$key]['legal_pid'] = $data['legal_pid'][$key];
        }

        $client->property_security = serialize($securityArr);

        $client->amount = str_replace(' ', '', $data['amount']);
        $client->start_date = $data['start_date'];
        $client->term = $data['term'];
        $client->rate = $data['rate'];
        $client->amortization_period = $data['amortization_period'];
        $client->payment_type = isset($data['payment_type']) ? 1 : 2;
        $client->payment_method = $data['payment_method'];

        $client->save();

        return response()->json([
            'status' => 1,
        ]);
    }

    // User part
    public function users()
    {
        return view('users', array('activeMenu' => 'users'));
    }

    public function usersData(Request $request)
    {

        $model = new User();

        $filter = false;
        if (isset($request->input('search')['value']) && $request->input('search')['value'] != '') {
            $filter['search'] = $request->input('search')['value'];
        }

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir')
        );
        return json_encode(array('data' => $items['data'], "recordsFiltered" => $items['count'], 'recordsTotal' => $items['count']));
    }

    public function getUser(Request $request)
    {
        $userId = $request->input('user_id', false);
        $user = $userId && $userId != 'false' ? User::find($userId) : false;
        return view('user_popup', array('user' => $user));
    }

    public function saveUser(Request $request)
    {
        $data = $request->all();

        $userId = $data['user_id'];

        $validations = array(
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => ['required', Rule::unique('users')->ignore($userId)],
            'password' => 'required|confirmed'
        );

        $password = $data['password'];

        $setPassword = true;
        if ($userId && $userId != 0) {
            $user = User::find($userId);

            if (strlen($password) < 1) {
                $setPassword = false;
                unset($validations['password']);
            }
        } else {
            $user = new User();

        }

        $validator = Validator::make($data, $validations);

        if ($validator->fails()) {
            $html = "<div>";

            foreach ($validator->errors()->all() as $error) {
                $html .= "<span>" . $error . "</span>";
            }
            $html .= "</div>";
            return json_encode(array('status' => 0, 'errors' => $html));
        }

        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];
        $user->address = $data['address'];
        if ($setPassword) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        return json_encode(array('status' => 1));
    }

    // Get-agent
    public function getAgent(Request $request)
    {
        $id = $request->input('id', false);

        $client = Clients::find($id);
        $agent = Agents::find($client->agent_id);

        return view('agent_popup', array('client' => $client, 'agent' => $agent));
    }

    public function saveAgent(Request $request)
    {
        $data = $request->all();

        $clientId = $data['client_id'];

        $validations = array(
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
        );

        $client = Clients::find($clientId);
        $agent = Agents::find($client->agent_id);

        $validator = Validator::make($data, $validations);

        if ($validator->fails()) {
            $html = "<div>";

            foreach ($validator->errors()->all() as $error) {
                $html .= "<span>" . $error . "</span>";
            }
            $html .= "</div>";
            return json_encode(array('status' => 0, 'errors' => $html));
        }

        $agent->name = $data['name'];
        $agent->phone = $data['phone'];
        $agent->email = $data['email'];
        $agent->save();

        return response()->json([
            'status' => 1,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();

        $clientId = $data['clientId'];
        $status = $data['status'];

        $client = Clients::find($clientId);
        $client->status = $status;
        $client->save();

        return json_encode(array('status' => 1));
    }

    public function getRenewalDate($closingDate, $term = null)
    {
        $term++;
        $newDate = date('Y-m', strtotime("+" . $term . " months", strtotime($closingDate)));
        if ($newDate) return $newDate . "-01";
        return false;
    }

    // Mortgages part
    public function mortgages()
    {
        $fee = Settings::where('key', 'fee')->first();
        $fees = unserialize($fee->value);

        return view('mortgages', array('fees' => $fees, 'activeMenu' => 'mortgages'));
    }

    public function saveSettings(Request $request)
    {
        $data = $request->all();

        $validations = array(
            'mortgage_fee' => 'numeric|required',
            'broker_fee' => 'numeric|required',
            'lender_fee' => 'numeric|required',
            'admin_fee' => 'numeric|required',
            'lawyer_fee' => 'numeric|required',
            'appraisal_fee' => 'numeric|required',
        );


        $validator = Validator::make($data, $validations);

        if ($validator->fails()) {
            $html = "<div>";

            foreach ($validator->errors()->all() as $error) {
                $html .= "<span>" . $error . "</span>";
            }
            $html .= "</div>";
            return json_encode(array('status' => 0, 'errors' => $html));
        }


        $settings = array();
        $settings['mortgage'] = array('fee' => $data['mortgage_fee']);
        $settings['broker'] = array('fee' => $data['broker_fee']);
        $settings['lender'] = array('fee' => $data['lender_fee']);
        $settings['admin'] = array('fee' => $data['admin_fee']);
        $settings['lawyer'] = array('fee' => $data['lawyer_fee']);
        $settings['appraisal'] = array('fee' => $data['appraisal_fee']);

        $settings = serialize($settings);
        $fee = Settings::where('key', 'fee')->first();
        $fee->value = $settings;
        $fee->save();

        return response()->json([
            'status' => 1,
            'message' => 'Update successfully.'
        ]);
    }

    public function show($id)
    {

        $client = Clients::find($id);
        $lender = Agents::find($client->lender_id);
        $lawyer = Agents::find($client->lawyer_id);
        $agent = Agents::find($client->agent_id);

        $data = [
            'activeMenu' => 'clients',
            'client' => $client,
            'lender' => $lender,
            'lawyer' => $lawyer,
            'agent' => $agent,
        ];
        return view('show', $data);
    }

    public function destroyClient(int $id)
    {
        $client = Clients::find($id);
        $client->delete();
        return redirect()->route('clients');
    }

}
