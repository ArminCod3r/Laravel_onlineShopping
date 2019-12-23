<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use DB;
use App\Product;
use App\AmazingProducts;

class SiteController extends Controller
{
	private $categories = array();

	public function __construct()
	{
		$categories = self::categoryTree();
		View::share('categories', $categories);
	}

    public function index()
    {
        // Get list of the sliders
        $sliders = DB::table('slider')->orderBy('id', 'DESC')->get();

        $newest_products = Product::with('ProductImage')  // Adding ProductImage[] for image names
                                  ->where('product_status',1)
                                  ->orderBy('id', 'DESC')
                                  ->limit(15)
                                  ->get()
                                  ->toArray();
        

        $amazing_products= AmazingProducts::with('ProductImage')
                                          ->with('Product_details')
                                          ->orderBy('id', 'desc')
                                          ->get();

    	return view('site.index')->with([                              // $this->categories
                                        'sliders'         => $sliders,
                                        'newest_products' => $newest_products,
                                        'amazing_products'=> $amazing_products,
                                        ]); 
    }

    public function showProduct($code, $title_url)
    {
        $code = str_replace('-',' ', $code);

        $product = Product::with('ProductImage')->where(['code'         => $code,
                                                'title_url'    => $title_url,
                                                'show_product' => 1])
                                                ->firstOrFail();

        return view('site.showProduct')->with('product', $product);
    }





    // Recursive Method to get all the categories/subcategories
    private function categoryTree($parent_id = 0, $sub_mark = '')
    {
	    $query = DB::table('category')
                ->select('*')
                ->where('parent_id',$parent_id)
                ->get()
                ->pluck('cat_name','id');

        
        foreach ($query as $key => $value)
        {
        	//echo $key." : ".$sub_mark.$value."</br>";
        	array_push($this->categories, $value.':'.$parent_id.'-'.$key);
        	$this->categoryTree($key, $sub_mark.'---');
        }
        return $this->categories;
	}

}
