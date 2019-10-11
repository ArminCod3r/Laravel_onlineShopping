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
    private $categories = array();

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
        $categories = self::categoryTree();

        return view('admin/category/create')->with('categories', $categories);
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

        //$url = 'admin/category/'.$category->id.'/edit';
        return redirect('admin/category/');
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

        $categories = self::categoryTree();
        
        return view('admin/category/edit', ['category'=> $category , 'categories'=>$categories]);
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

    // Recursive Method to get all the categories/subcategories
    private function categoryTree($parent_id = 0, $sub_mark = '')
    {
        $query = DB::table('category')
                ->select('*')
                ->where('parent_id',$parent_id)
                ->get()
                ->pluck('cat_name','id');

        
        foreach ($query as $id => $value)
        {
            //echo $key." : ".$sub_mark.$value."</br>";
            array_push($this->categories, $sub_mark.$value.':'.$id);
            $this->categoryTree($id, $sub_mark.'---');
        }
        return $this->categories;
    }
}
