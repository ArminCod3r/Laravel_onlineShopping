<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\State;
use DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::with("State")->orderBy('id', 'desc')->paginate(10);

        return view('admin/city/index')->with('cities', $cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();

        return view('admin/city/create')->with('states', $states);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $state_id  = $request->input('state');
        $city_name = $request->input('city');

        State::findOrFail($state_id);

        $city = new City();
        $city->name = $city_name;
        $city->state_id = $state_id;
        $city->save();

        return redirect('admin/city/');
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
        $city = City::findOrFail($id);
        $states = State::all();

        return view('admin/city/edit')->with([
                                             'city' => $city,
                                             'states' => $states,
                                             ]);
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
        $city_id   = $id;
        $city_name = $request->input('city');
        $state_id  = $request->input('state');

        $city  = City::findOrFail($id);
        $state = State::findOrFail($state_id);

        DB::table('city')->where('id', $id)
                         ->update([
                            'name'     => $city_name,
                            'state_id' => $state_id
                         ]);

        return redirect('admin/city/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);

        $city->delete();

        return redirect('admin/city/');
    }
}
