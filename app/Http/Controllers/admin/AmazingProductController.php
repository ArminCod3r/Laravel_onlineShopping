<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\AmazingProducts;
use App\Http\Requests\AmazingProductRequest;
use App\Http\Controllers\Controller;

class AmazingProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amazing = AmazingProducts::orderBy('id', 'desc')->paginate(10);

        return view('admin/amazing_products/index')->with('amazing', $amazing);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/amazing_products/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AmazingProductRequest $request)
    {
        $amazing = new AmazingProducts($request->all());

        // Changing time_amazing to second
        $amazing->time_amazing_timestamp = time() + $request->get('time_amazing') * 60 * 60;

        $amazing->saveOrFail();

        $url = 'admin/amazing_products/'.$amazing->id.'/edit';
        return redirect($url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $amazing = AmazingProducts::findOrFail($id);

        return view('admin/amazing_products/edit')->with('amazing', $amazing);
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
        $amazing = AmazingProducts::findOrFail($id);

        // Preventig from refreshing the 'timestamp' in case of not changing the 'time'
        if ( $request->get('time_amazing') != $amazing->time_amazing)
            $amazing->time_amazing_timestamp = time() + $request->get('time_amazing') * 60 * 60;
        
        $amazing->update($request->all());

        $url = 'admin/amazing_products/'.$amazing->id.'/edit';
        return redirect($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
