<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use DB;
use App\Product;
use App\AmazingProducts;
use App\Review;
use App\FeatureAssign;
use App\Category;
use App\Feature;

use App\Lib\CheckColorProduct;


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

        $product = Product::with('ProductImage')->with("color_product_frontend")

                                                ->where(['code'        => $code,
                                                        'title_url'    => $title_url,
                                                        'show_product' => 1])

                                                ->firstOrFail();

        $review = Review::where('product_id', $product->id)->get();

        //$category = Category::findOrFail($category_id);

        // get the parent(s)
        $product_To_category = Product::ProductID_To_CategoryName($product->id);
        $features="";

        // get the categories
        // get the one that is not empty
        // BEST approach => taking controll of which one to show via admin panel.
        foreach ($product_To_category as $key => $value)
        {
          $product_category = $value->id;

          $features_temp = Feature::where('category_id', $product_category)->get();

          if(count($features_temp)>0)
            $features = $features_temp;
        }
        

        $assigned_features = FeatureAssign::where('product_id', $product->id)->get();
        $assigned_features_key = array();

        if( count($assigned_features) > 0 )
        {
            // Sorting array -> [feature_id] = value
            foreach ($assigned_features as $key => $value)
            {
                $assigned_features_key[$value['feature_id']] = $value['value'];
            }
        }


        return view('site.showProduct')->with([
                                               'product'  => $product,
                                               'review'   => $review,
                                               'features' => $features,
                                               'assigned_features_key' => $assigned_features_key,
                                              ]);
    }


    // Cart
    public function cart(Request $request)
    {

      $color      = $request->get('color_session');
      $product_id = $request->get('product_session');

      // Checking using class
      $checked = CheckColorProduct::verify($color, $product_id);
      
      if ( is_array($checked) )
      {
          list($color_id, $product_id) = $checked; // Assigning array to variables (3340750)

          if($request->session()->has('product'))
          {
              return "Session : ".$request->session()->get('product');
          }
          else
          {
              $request->session()->put('product', $product_id.":".$color_id.":1");

              return 'Session has been set...';
          }
      }
      else
      {
          return abort(404);
      }
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
