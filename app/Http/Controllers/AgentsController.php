<?php

namespace App\Http\Controllers;

use App\Agents;
use Illuminate\Http\Request;

class AgentsController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $type = (int)($request->type ? $request->type : 1);

        $agents = Agents::where('type', '=', $type)->paginate(15);

        return view('agents.index', [
            'activeMenu' => 'agents',
            'agents' => $agents,
            'type' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return  view('agents.create',[
            'activeMenu' => 'agents',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required',
            'phone' => 'required',
            'type'  => 'required',
        ]);
        $agent = new Agents();
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->phone = $request->phone;
        $agent->type = $request->type;
        $agent->save();

        return redirect()->route('agents.edit', ['agent' => $agent->id])->with('success', 'Agent created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $agent = Agents::find($id);

        return view('agents.edit',
            [
                'activeMenu' => 'agents',
                'agent' => $agent,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
        $agent = Agents::find($id);
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->phone = $request->phone;
        $agent->save();

        return redirect()->route('agents.edit', ['agent' => $id])->with('success', 'Agent update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Agents::destroy($id);

        return redirect()->route('agents.index');
    }
}
