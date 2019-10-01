<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Http\Requests\ProductRequest;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return Product::searchProduct($request->input('search_product_fa'));

        $products  = "";
        $search_product = "";

        if ($request->input('search_product'))
        {
             $search_product = $request->input('search_product');
             $products = Product::searchProduct($search_product);

             $path = 'product?search_product_fa='.$search_product;
             $products->setPath($path);
        }

        else
            $products = Product::orderBy('id', 'desc')->paginate(5);

        $colors = Product::getColor();
        $colors = (array)$colors;

        return view('admin/product/index', ['products'=> $products , 'colors'=>$colors]);
        //->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat_list = array();
        $cat_list[0]='انتخاب سر دسته';
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

        return view('admin/product/create')->with('cat_list', $cat_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product($request->all());

        /*$product->title          = $request->input('title');
        $product->code           = $request->input('code');
        $product->title_url      = $request->input('title_url');
        $product->code_url       = $request->input('code_url');
        $product->price          = $request->input('price');
        $product->discounts      = $request->input('discounts');
        $product->view           = $request->input('view');
        $product->text           = $request->input('text');
        $product->product_status = $request->input('product_status');
        $product->bon            = $request->input('bon');
        $product->show_product   = $request->input('show_product');
        $product->product_number = $request->input('product_number');
        $product->order_product  = $request->input('order_product');
        $product->keywords       = $request->input('keywords');
        $product->description    = $request->input('description');
        $product->special        = $request->input('special');*/

        // CKeditor
        $product->text = $request->input('article-ckeditor');

        // TITLE convert: '-','/' >TO> '-'
        $url = str_replace('-', ' ', $request->title);
        $url = str_replace('/', ' ', $url);
        $product->title_url = preg_replace('/\s+/', '-', $url);

        // CODE_URL convert: '-','/' >TO> '-'
        $code_url = str_replace('-', ' ', $request->code_url);
        $code_url = str_replace('/', ' ', $code_url);
        $product->code_url = preg_replace('/\s+/', '-', $code_url);

        $product->view = 0;
        $product->order_product = 0; // Tedad-E forosh
        $product->special = 0;
        $product->product_status = ($request->has('product_status')) ? $request->input('product_status') : 0;  
        //if $request->input('product_status') 
        //    $request->input('product_status')
        //else
        //    0;

        $product->save();

        $parents= $request->input('cat');
        foreach ($parents as $item)
        {
            // NOTE: $product->id is only avaliable after saveing the current row.
            DB::table('parent_product')->insert(['product_id'=>$product->id, 'parent_id'=>$item]);
        }

        if(is_array($request->input('color')))
        {
            $colors = $request->input('color');
            foreach ($colors as $key => $item)
            {
                if(!empty($item))
                    DB::table('color_product')->insert(['color_code'=>$item, 'product_id'=>$product->id]);
            }
        }
        
        $url = 'admin/product/'.$product->id.'/edit';
        return redirect($url);

        //return $request->all(); //laravel get request body
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
        $product = Product::find($id);

        $cat_list = array();
        $cat_list[0]='انتخاب سر دسته';
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

        $parents = Product::getParent($product->id);
        //$row = ((array)$parents[0]);
        //return $row["cat_name"];

        $parents_array= array();
        foreach ($parents as $key=>$item)
        {
            $parents_array[$key] = ((array)$item)["cat_name"];
        }

        $colors_product = Product::getColor($product->id);

        $keywords = $product->keywords;
        $keywords = Product::keywords_trimming($keywords);        

        return view('admin/product/edit')->with(['product'        => $product,
                                                 'cat_list'       => $cat_list,
                                                 'parents'        => $parents_array,
                                                 'colors_product' => $colors_product,
                                                 'keywords'       => $keywords,
                                                 ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        //DB::connection()->enableQueryLog();
        //return $request->all();

        $product = Product::findOrFail($id);

        $product->product_status="1";

        $product->update($request->all());

        // CKeditor
        $product->text = $request->input('article-ckeditor');

        // TITLE convert: '-','/' >TO> '-'
        $url = str_replace('-', ' ', $request->title);
        $url = str_replace('/', ' ', $url);
        $product->title_url = preg_replace('/\s+/', '-', $url);

        // CODE_URL convert: '-','/' >TO> '-'
        $code_url = str_replace('-', ' ', $request->code_url);
        $code_url = str_replace('/', ' ', $code_url);
        $product->code_url = preg_replace('/\s+/', '-', $code_url);
        
        $product->view = 0;
        $product->order_product = 0; // Tedad-E forosh
        $product->special = 0;

        $product->keywords;

        $product->save();

        // Other tables

        $parents= $request->input('cat');
        if(!empty($parents))
        {
            // Delete previous parenrts
            DB::table('parent_product')->where('product_id', $product->id)->delete();

            foreach ($parents as $item)
            {
                // NOTE: $product->id is only avaliable after saveing the current row.
                DB::table('parent_product')->insert(['product_id'=>$product->id, 'parent_id'=>$item]);
            }
        }
        

        $colors_arr = array();
        if(is_array($request->input('color')))
        {
            // Delete previous colors
            DB::table('color_product')->where('product_id', $product->id)->delete();

            $colors = $request->input('color');
            foreach ($colors as $key => $item)
            {
                if(!empty($item))
                {
                    // Insert new colors
                    DB::table('color_product')
                        ->insert(['color_code'=>$item, 'product_id'=>$product->id]);
                }
            }
        }
        // To see the raw query that was just executed.
        //dd(DB::getQueryLog());
        
        $url = 'admin/product/';
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
        $product = Product::find($id);

        if($product)
        {
            // Delete Product
            $product->delete();

            // Delete Product's Color
            DB::table('color_product')->where('product_id', $product->id)->delete();

            // Delete Product's Parents
            DB::table('parent_product')->where('product_id', $product->id)->delete();
        }

        return redirect()->back();
    }

    // Showing the gallery page
    public function gallery(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        return view('admin/product/gallery')->with('product', $product);
    }

    // Uploading the images
    public function upload(Request $request, $id)
    {
        $files = $request->file('file');        

        $fileName = time().(rand(10,1000)).'.'.$files->getClientOriginalExtension();
        $files->move('upload', $fileName);
    }
}
