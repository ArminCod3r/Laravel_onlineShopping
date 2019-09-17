<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories="";
        $same_url="";

        if( $request->input('cat_name') || $request->input('cat_ename') ) //array_key_exists('cat_name', $request)
        {
            $cat_name = $request->input('cat_name'); // Input::get('cat_name');
            $cat_ename = $request->input('cat_ename');

            $categories = Category::where('cat_name', 'like', '%'.$cat_name.'%')->paginate(1);

            $same_url = 'category?cat_name='.$cat_name.'&'.'cat_ename='.$cat_ename;
            $categories->setPath($same_url); //stack: 34946402
        }
        else
            $categories = Category::orderBy('id', 'desc')->paginate(4);   

        return view('admin/category/index')->with('categories', $categories);
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
            $cat_list[($item->id)-1]=$item->cat_name;

            foreach ($item->getChild as $key2=>$item2)
            {
                $cat_list[($item2->id)-1]=' - '.$item2->cat_name;

                foreach ($item2->getChild as $key3=>$item3)
                {
                    $cat_list[($item3->id)-1]=' - - '.$item3->cat_name;
                }
            }
        }

        /*$cat_list2 = array();
        $cat_list3 = array();

        for ($i = 0;$i<=count($cat)-1; $i++)
        { 
            $cat_list2[$i]= $cat[$i]->cat_name;

            foreach ($cat[$i]->getChild as $key => $item)
            {
                $cat_list2[$i++]= ' - '.$item;
            }
        }

        return $cat_list2;*/

        //return $cat_list;
        return view('admin/category/create')->with('cat_list', $cat_list);
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

        $url = 'admin/category/'.$category->id.'/edit';
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
        $category = Category::find($id);

        $cat_list = array();
        //$cat_list[0]='انتخاب سر دسته';
        $cat = Category::where('parent_id',0)->get(); //get: cat_name

        foreach ($cat as $key=>$item)
        {
            $cat_list[($item->id)-1]=$item->cat_name;

            foreach ($item->getChild as $key2=>$item2)
            {
                $cat_list[($item2->id)-1]=' - '.$item2->cat_name;

                foreach ($item2->getChild as $key3=>$item3)
                {
                    $cat_list[($item3->id)-1]=' - - '.$item3->cat_name;
                }
            }
        }

        //return $cat_list;

        //return ($category->getParent()->get())[0]->id; // stackoverflow: 34571957
        return view('admin/category/edit', ['category'=> $category , 'cat_list'=>$cat_list]);
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
        $category = Category::find($id);

        $category->cat_name = $request->input('cat_name');
        $category->cat_ename = $request->input('cat_ename');
        $category->parent_id = $request->input('parent_id');

        if($request->hasFile('img'))
        {
            $fileName = time().'.'.$request->file('img')->getClientOriginalExtension();

            $path = 'upload/'.$category->img;
            if(file_exists($path))
            {
                unlink($path);
            }
            
            if($request->file('img')->move('upload', $fileName))
            {
                $category->img = $fileName;
            }

        }

        $category->save();

        $url = 'admin/category/'. $id .'/edit';
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
        $category = Category::find($id);

        $category->delete();

        $path = 'upload/'.$category->img;
        if(file_exists($path))
        {
            unlink($path);
        }

        return redirect()->back();;
    }
}
