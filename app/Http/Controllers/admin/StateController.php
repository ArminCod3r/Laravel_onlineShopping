<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\State;
use DB;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$states = State::orderBy('id','desc')->paginate(10);

        $states = State::with('City')->paginate(10);

        return view('admin/state/index')->with('states', $states);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/state/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
                    'state' => 'required|max:250|unique:state,name',
                ];

        $customMessages = [
                    'required' => ':attribute الزامی است',
                    'unique' => ':attribute تکراری است',
                ];

        $fieldsName=[
                    'state' => 'نام استان',
                ];

        $validator = Validator::make($request->all(), $rules, $customMessages, $fieldsName);


        if ($validator->fails()) 
            $this->validate($request, $rules, $customMessages, $fieldsName);

        else
        {
            $state = new State();
            $state->name = $request->input('state');
            $state->save();

            return redirect('admin/state/');
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = State::findOrFail($id);

        return view('admin/state/edit')->with('state', $state);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        State::findOrFail($id);

        $state = $request->input('state');

        DB::table('state')->where('id', $id)->update(['name' => $state]);

        return redirect('admin/state/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);

        $state->delete();

        return redirect('admin/state/');
    }
}
