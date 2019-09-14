<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat_list = array();
        //$cat_list[0]='انتخاب سر دسته';
        $cat = Category::where('parent_id',0)->get(); //get: cat_name

        foreach ($cat as $key=>$item)
        {
            $cat_list[$item->id]=$item->cat_name;

            foreach ($item->getChild as $key2=>$item2)
            {
                $cat_list[$item2->id]=' - '.$item2->cat_name;

                foreach ($item2->getChild as $key3=>$item3)
                {
                    $cat_list[$item3->id]=' - - '.$item3->cat_name;
                }
            }
        }

        //return $cat_list;
        return view('category/create')->with('cat_list', $cat_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();

        if($request->hasFile('img'))
        {
            $fileName = time().'.'.$request->file('img')->getClientOriginalExtension();

            if($request->file('img')->move('upload', $fileName))
                $category->img = $fileName;

        }
        //$category->saveorFail();
        
        $category->cat_name = $request->input('cat_name');
        $category->cat_ename = $request->input('cat_ename');
        $category->parent_id = $request->input('parent_id');
        $category->save();

        $url = 'category/'.$category->id.'/edit';
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
        return $id;
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
