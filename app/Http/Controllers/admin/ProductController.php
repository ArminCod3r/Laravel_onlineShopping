<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\ProductImage;
use App\Http\Requests\ProductRequest;
use DB;

class ProductController extends Controller
{
    private $categories = array();

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
        $images = "";

        if ($request->input('search_product'))
        {
             $search_product = $request->input('search_product');
             $products = Product::searchProduct($search_product);

             $path = 'product?search_product_fa='.$search_product;
             $products->setPath($path);
        }

        else
        {
            $products = Product::orderBy('id', 'desc')->paginate(5);
        }

        $colors = Product::getColor();
        $colors = (array)$colors;

        // Adding image to the Products obj as a property
        foreach ($products as $key => $item)
        {
            // check for if image of a product is avaliable
            if(($item->ProductImage)->count() > 0)
                $item->img = $item->ProductImage->first()->url;
            else
                $item->img = "";
        }


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
        $categories = self::categoryTree();

        return view('admin/product/create')->with('categories', $categories);
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

        $categories = self::categoryTree();

        $parents = Product::getParent($product->id);
        //$row = ((array)$parents[0]);
        //return $row["cat_name"];

        //return $parents;

        $colors_product = Product::getColor($product->id);

        $keywords = $product->keywords;
        $keywords = Product::keywords_trimming($keywords);        

        return view('admin/product/edit')->with(['product'        => $product,
                                                 'categories'     => $categories,
                                                 'parents'        => $parents,
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

        $images= $product->ProductImage;

        return view('admin/product/gallery', ['product' => $product,
                                              'images'  => $images,
                                              ]);
    }

    // Uploading the images
    public function upload(Request $request, $id)
    {
        $files = $request->file('file');

        $rules = array(
            'file' => 'image|max:1999',
        );       

        $fileName = time().(rand(10,1000)).'.'.$files->getClientOriginalExtension();
        
        // Set the return value for Dropzone
        if($files->move('upload', $fileName))
        {
            $product_image = new ProductImage();

            // escape special characters [stack: 14114411]
            $id = str_replace(' ', '-', $id); // Replaces all spaces with hyphens.
            $id = preg_replace('/[^A-Za-z0-9\-]/', '', $id); // Removes special chars.

            $product_image->product_id = $id;
            $product_image->url = $fileName;

            $product_image->Save();

            return 1;
        }
        else
            return 0;
    }

    public function deleteImage($img)
    {
        $image = ProductImage::findOrFail($img);

        if ($image->url)
        {
            $path = 'upload/'.$image->url;            

            if(file_exists($path))
            {
                $image->delete();

                unlink($path);
            }
        }

        return redirect()->back();
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
