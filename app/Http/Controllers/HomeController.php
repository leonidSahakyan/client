<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Settings;
use App\Agents;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public $AGENT_TYPE = 1;
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
        return view('dashboard', array('activeMenu'=>'clients'));
    }

    public function clientsData(Request $request){

        $model = new Clients();

        $filter['status'] = $request->input('filter_status');

        if(isset($request->input('search')['value']) && $request->input('search')['value'] != ''){
            $filter['search'] = $request->input('search')['value'];
        }

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir')
        );
        $data = json_encode(array('data' => $items['data'], "recordsFiltered"=>$items['count'], 'recordsTotal' => $items['count']));

        return $data;
    }

    public function getClient(Request $request){
        $id = $request->input('client_id',false);
        $client = $id && $id != 'false'  ? Clients::find($id) : false;

        if($client && $client->custom_fee == 1){
            $fees = unserialize($client->settings);
        }else{
            $fee = Settings::where('key','fee')->first();
            $fees = unserialize($fee->value);
        }

        $agents = Agents::all();

        return view('client_popup', array('client'=>$client,'fees'=>$fees,'agents'=>$agents));
    }

    public function saveClient(Request $request){
        $data = $request->all();
//        dump($data);
//        die;
        $clientId = $data['client_id'];

        $validations = array(
            'type' => 'required|in:1,2',
            'status' => 'required|in:1,2,3',
            'term' => 'integer|nullable',
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'dob' => 'required|string',
            'closing_date' => 'required|string',
            'agent_name' => 'required|string',
            'agent_phone' => 'required|string',
            'agent_email' => 'required|string',
            'custom_fee_switcher' => 'nullable',
            'lender_name' => 'required|string',
            'lender_phone' => 'required|string',
            'lender_email' => 'required|string',
            'lawyer_name' => 'required|string',
            'lawyer_phone' => 'required|string',
            'lawyer_email' => 'required|string',
            'mortgage_fee' => 'numeric|required',
            'mortgage_fee_type' => 'required|in:fixed,percent',
            'broker_fee' => 'numeric|required',
            'broker_fee_type' => 'required|in:fixed,percent',
            'lender_fee' => 'numeric|required',
            'lender_fee_type' => 'required|in:fixed,percent',
            'admin_fee' => 'numeric|required',
            'admin_fee_type' => 'required|in:fixed,percent',
            'lawyer_fee' => 'numeric|required',
            'lawyer_fee_type' => 'required|in:fixed,percent',
            'appraisal_fee' => 'numeric|required',
            'appraisal_fee_type' => 'required|in:fixed,percent',
        );

        $custom_fee_switcher = 0;
        if(isset($data['custom_fee_switcher'])){
            $custom_fee_switcher = 1;
        }else{
            unset($validations['mortgage_fee']);
            unset($validations['mortgage_fee_type']);
            unset($validations['broker_fee']);
            unset($validations['broker_fee_type']);
            unset($validations['lender_fee']);
            unset($validations['lender_fee_type']);
            unset($validations['admin_fee']);
            unset($validations['admin_fee_type']);
            unset($validations['lawyer_fee']);
            unset($validations['lawyer_fee_type']);
            unset($validations['appraisal_fee']);
            unset($validations['appraisal_fee_type']);
        }

        if($data['agent_id'] != '-1'){
            unset($validations['agent_name']);
            unset($validations['agent_phone']);
            unset($validations['agent_email']);
        }

        if($data['type'] == '1'){
            unset($validations['lawyer_name']);
            unset($validations['lawyer_phone']);
            unset($validations['lawyer_email']);
            if ($data['lender_id'] !== '-1'){
                unset($validations['lender_name']);
                unset($validations['lender_phone']);
                unset($validations['lender_email']);
            }
        }

        if($data['type'] == '2'){
            unset($validations['lender_name']);
            unset($validations['lender_phone']);
            unset($validations['lender_email']);
            if ($data['lawyer_id'] !== '-1'){
                unset($validations['lawyer_name']);
                unset($validations['lawyer_phone']);
                unset($validations['lawyer_email']);
            }
        }

        if($clientId && $clientId != 0){
            $client = Clients::find($clientId);
        }else{
            $client = new Clients();
        }

        $validator = Validator::make($data, $validations);

        if ($validator->fails()) {
            $html = "<div>";

            foreach($validator->errors()->all() as $error)
            {
                $html .= "<span>" . $error . "</span>";
            }
            $html .= "</div>";
            return json_encode(array('status' => 0,'errors'=>$html));
        }

        $client->type = $data['type'];
        $client->term = $data['term'];
        $client->name = $data['name'];
        $client->email = $data['email'];
        $client->closing_date = $data['closing_date'];
        $client->dob = $data['dob'];
        $client->phone = $data['phone'];
        $client->address = $data['address'];
        $client->status = $data['status'];

        $renewal_date = $this->getRenwalDate($client->closing_date,$data['term']);
        $client->renewal_date = $renewal_date ? $renewal_date : null;

        if($data['agent_id'] == '-1'){
            $newAgent = Agents::create(['name' => $data['agent_name'],
                                        'phone' => $data['agent_phone'],
                                        'email' => $data['agent_email'],
                                        'type' => $this->AGENT_TYPE
            ]);

            $client->agent_id = $newAgent->id;
        }else{
            $client->agent_id = $data['agent_id'];
        }

        // add lender
        if($data['type'] == 1){
            if( $data['lender_id'] == '-1'){
                $newAgent = Agents::create(['name' => $data['lender_name'],
                                            'phone' => $data['lender_phone'],
                                            'email' => $data['lender_email'],
                                            'type' => 2]);

                $client->lender_id = $newAgent->id;
            }else{
                $client->lender_id = $data['lender_id'];
            }
        }
        // add lawyer
        if($data['type'] == 2){

            if( $data['lawyer_id'] == '-1'){
                $newAgent = Agents::create(['name' => $data['lawyer_name'],
                                            'phone' => $data['lawyer_phone'],
                                            'email' => $data['lawyer_email'],
                                            'type' => $this->LAWYER_TYPE,
                ]);

                $client->lawyer_id = $newAgent->id;
            }else{
                $client->lawyer_id = $data['lawyer_id'];
            }
        }

        if($custom_fee_switcher == 1){
            $settings = array();
            $settings['mortgage'] = array('fee'=>$data['mortgage_fee'],'type'=>$data['mortgage_fee_type']);
            $settings['broker'] = array('fee'=>$data['broker_fee'],'type'=>$data['broker_fee_type']);
            $settings['lender'] = array('fee'=>$data['lender_fee'],'type'=>$data['lender_fee_type']);
            $settings['admin'] = array('fee'=>$data['admin_fee'],'type'=>$data['admin_fee_type']);
            $settings['lawyer'] = array('fee'=>$data['lawyer_fee'],'type'=>$data['lawyer_fee_type']);
            $settings['appraisal'] = array('fee'=>$data['appraisal_fee'],'type'=>$data['appraisal_fee_type']);

            $settings = serialize($settings);
            $client->settings = $settings;
        }
        $client->custom_fee = $custom_fee_switcher;

        $client->save();

        return json_encode(array('status' => 1));
    }

    // User part
    public function users()
    {
        return view('users', array('activeMenu'=>'users'));
    }

    public function usersData(Request $request){

        $model = new User();

        $filter = false;
        if(isset($request->input('search')['value']) && $request->input('search')['value'] != ''){
            $filter['search'] = $request->input('search')['value'];
        }

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir')
        );
        $data = json_encode(array('data' => $items['data'], "recordsFiltered"=>$items['count'], 'recordsTotal' => $items['count']));

        return $data;
    }

    public function getUser(Request $request){
        $userId = $request->input('user_id',false);
        $user = $userId && $userId != 'false'  ? User::find($userId) : false;
        return view('user_popup', array('user'=>$user));
    }

    public function saveUser(Request $request){
        $data = $request->all();

        $userId = $data['user_id'];

        $validations = array(
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => ['required',Rule::unique('users')->ignore($userId)],
            'password' => 'required|confirmed'
        );

        $password = $data['password'];

        $setPassword = true;
        if($userId && $userId != 0){
            $user = User::find($userId);

            if(strlen($password) < 1){
                $setPassword = false;
                unset($validations['password']);
            }
        }else{
            $user = new User();

        }

        $validator = Validator::make($data, $validations);

        if ($validator->fails()) {
            $html = "<div>";

            foreach($validator->errors()->all() as $error)
            {
                $html .= "<span>" . $error . "</span>";
            }
            $html .= "</div>";
            return json_encode(array('status' => 0,'errors'=>$html));
        }

        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];
        $user->address = $data['address'];
        if($setPassword){
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        return json_encode(array('status' => 1));
    }

    // Get-agent
    public function getAgent(Request $request){
        $id = $request->input('id',false);

        $client = Clients::find($id);
        $agent = Agents::find($client->agent_id);

        return view('agent_popup', array('client'=>$client,'agent'=>$agent));
    }

    public function saveAgent(Request $request){
        $data = $request->all();

        $clientId = $data['client_id'];

        $validations = array(
            'term' => 'integer|nullable',
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
        );

        $client = Clients::find($clientId);
        $agent = Agents::find($client->agent_id);

        $validator = Validator::make($data, $validations);

        if ($validator->fails()) {
            $html = "<div>";

            foreach($validator->errors()->all() as $error)
            {
                $html .= "<span>" . $error . "</span>";
            }
            $html .= "</div>";
            return json_encode(array('status' => 0,'errors'=>$html));
        }

        $client->term = $data['term'];
        $renewal_date = $this->getRenwalDate($client->closing_date,$data['term']);
        $client->renewal_date = $renewal_date ? $renewal_date : null;
        $client->save();

        $agent->name = $data['name'];
        $agent->phone = $data['phone'];
        $agent->email = $data['email'];
        $agent->save();

        return json_encode(array('status' => 1));
    }

    public function changeStatus(Request $request){
        $data = $request->all();

        $clientId = $data['clientId'];
        $status = $data['status'];

        $client = Clients::find($clientId);
        $client->status = $status;
        $client->save();

        return json_encode(array('status' => 1));
    }
    public function getRenwalDate($closingDate,$term){
        $term++;
        $newDate = date('Y-m', strtotime("+".$term." months", strtotime($closingDate)));
        if($newDate)return $newDate."-01";
        return false;
    }

    // Mortgages part
    public function mortgages()
    {
        $fee = Settings::where('key','fee')->first();
        $fees = unserialize($fee->value);

        return view('mortgages', array('fees' => $fees,'activeMenu'=>'mortgages'));
    }

    public function saveSettings(Request $request){
        $data = $request->all();

        $validations = array(
            'mortgage_fee' => 'numeric|required',
            'mortgage_fee_type' => 'required|in:fixed,percent',
            'broker_fee' => 'numeric|required',
            'broker_fee_type' => 'required|in:fixed,percent',
            'lender_fee' => 'numeric|required',
            'lender_fee_type' => 'required|in:fixed,percent',
            'admin_fee' => 'numeric|required',
            'admin_fee_type' => 'required|in:fixed,percent',
            'lawyer_fee' => 'numeric|required',
            'lawyer_fee_type' => 'required|in:fixed,percent',
            'appraisal_fee' => 'numeric|required',
            'appraisal_fee_type' => 'required|in:fixed,percent',
        );


        $validator = Validator::make($data, $validations);

        if ($validator->fails()) {
            $html = "<div>";

            foreach($validator->errors()->all() as $error)
            {
                $html .= "<span>" . $error . "</span>";
            }
            $html .= "</div>";
            return json_encode(array('status' => 0,'errors'=>$html));
        }


        $settings = array();
        $settings['mortgage'] = array('fee'=>$data['mortgage_fee'],'type'=>$data['mortgage_fee_type']);
        $settings['broker'] = array('fee'=>$data['broker_fee'],'type'=>$data['broker_fee_type']);
        $settings['lender'] = array('fee'=>$data['lender_fee'],'type'=>$data['lender_fee_type']);
        $settings['admin'] = array('fee'=>$data['admin_fee'],'type'=>$data['admin_fee_type']);
        $settings['lawyer'] = array('fee'=>$data['lawyer_fee'],'type'=>$data['lawyer_fee_type']);
        $settings['appraisal'] = array('fee'=>$data['appraisal_fee'],'type'=>$data['appraisal_fee_type']);

        $settings = serialize($settings);
        $fee = Settings::where('key','fee')->first();
        $fee->value = $settings;
        $fee->save();

        return json_encode(array('status' => 1));
    }

}
