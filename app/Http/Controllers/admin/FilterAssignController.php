<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Filter;
use App\Category;
use App\ProductImage;
use App\FilterAssign;
use DB;

class FilterAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/filter_assign/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: validation

        $product_id = $request->input('product_id');
        $category_id= $request->input('category_id');
        $filters    = $request->input('filter');

        // Deleting prev. values
        $filter_assigned = FilterAssign::where('product_id', $product_id)->delete();

        // Inserting values to the database
        foreach($filters as $key => $value)
        {
            $id   = explode('-', $value)[0];
            $name = explode('-', $value)[1];

            $filter_assign = new FilterAssign();

            $filter_assign->filter_id  = $key;
            $filter_assign->product_id = $product_id;
            $filter_assign->value      = $name;
            $filter_assign->value_id   = $id;

            $filter_assign->save();
        }

        $url = 'admin/filter_assign/'.$category_id.'/'.$product_id.'/edit';

        return redirect($url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category_id, $product_id)
    {
        $filters = Filter::where('category_id', $category_id)->get();
        $image   = ProductImage::where('product_id', $product_id)->first();

        return view('admin/filter_assign/show')->with([
                                                        'filters' => $filters,
                                                        'image'   => $image,
                                                        'category_id' => $category_id,
                                                      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
