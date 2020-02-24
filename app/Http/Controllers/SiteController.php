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
use App\ProductScore;
use Auth;

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
        $categories = Category::all();
        $categories = json_decode($categories, true);

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
                                        'categories'      => $categories,
                                        ]); 
    }

    public function showProduct($code, $title_url)
    {
        $categories = Category::all();
        $categories = json_decode($categories, true);

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

        // Count of the scores
        $scores_count = count(ProductScore::with('User')->where('product_id', $product->id)->get()->groupBy('user_id'));

        // Score average
        $all_scores   = ProductScore::where('product_id', $product->id)->pluck('score_value')->toArray();
        $avg_scores   = array_sum($all_scores) / count($all_scores);
        $avg_scores   = (int)number_format((float)$avg_scores, 2, '.', ''); // 4483540: Show a number to two decimal places
        $percent_score= ($avg_scores*100)/5;


        return view('site.showProduct')->with([
                                               'product'  => $product,
                                               'review'   => $review,
                                               'features' => $features,
                                               'assigned_features_key' => $assigned_features_key,
                                               'categories'      => $categories,
                                               'scores_count'    => $scores_count,
                                               'percent_score'   => $percent_score,
                                              ]);
    }


    // Cart
    public function cart(Request $request)
    {
      $method = $_SERVER['REQUEST_METHOD'];

      // Set Session
      if( $method == "POST")
      {
        $color      = $request->get('color_session');
        $product_id = $request->get('product_session');

        // Checking using class
        $checked = CheckColorProduct::verify($color, $product_id);
        
        if ( is_array($checked) )
        {
            list($color_id, $product_id) = $checked; // Assigning array to variables (3340750)


            $cart = $request->session()->has('cart');

            if($cart)
            {
                $cart       = $request->session()->get('cart');
                $custom_key = $product_id."-".$color_id;

                // if same product-color => multiple orders :  [p-c]:n
                if(array_key_exists($custom_key, $cart))
                {

                  $count_product = ((int)($cart[$custom_key]));
                  $count_product++;

                  $cart[$custom_key] = $count_product;                    

                }

                else
                {
                  $custom_key = $product_id."-".$color_id;
                  $cart[$custom_key] = 1;
                }
            }

            else
            {
                $custom_key = $product_id."-".$color_id;
                $cart[$custom_key] = 1;
            }

            $request->session()->put('cart', $cart);

            //return $request->session()->get('cart');
        }
        else
        {
            return abort(404);
        }

        // By using redirect we can hit => if($method =="GET")
        return redirect('cart/');
      }

      // Show cart
      if( $method == "GET")
      {
        $cart_details = array();

        if($request->session()->has('cart'))
        {          
          foreach ($request->session()->get('cart') as $key => $value)
          {
            $product_id_ = explode("-", $key)[0];
            $color_id_   = explode("-", $key)[1];

            $query = DB::table('product')
                        ->join('color_product', 'product.id', '=', 'color_product.product_id')
                        ->join('product_images', 'product.id', '=', 'product_images.product_id')

                        ->where('product.id',$product_id_)
                        ->where('color_product.id',$color_id_)
                        ->where('product_images.tag', '!=', 'review')

                        ->limit(1)

                        ->get()
                        ->toArray();

            $cart_details[$key] = $query;

          }
        }

        if($request->session()->has('cart'))
          return view('site.cart')->with([
                                          'cart'         => $request->session()->get('cart'),
                                          'cart_details' => $cart_details,
                                        ]);

        else
          return view('site.cart')->with('cart', null);
      }


    }

    public function cart_change(Request $request)
    {
      if($request->session()->has('cart'))
      {
        $product_id = $request->get('product_id');
        $color_id   = $request->get('color_id');
        $operation  = $request->get('operation');

        $cart       = $request->session()->get('cart');
        $cart_key   = $product_id.'-'.$color_id;

        if(array_key_exists($cart_key, $cart))
        {
          // Removing product from the cart
          if($operation == 'remove')
          {
              unset($cart[$cart_key]);

              $request->session()->put('cart', $cart);
          }

          // Adding quantity to the cart
          if($operation == 'add')
          {
            $count_product = ((int)($cart[$cart_key]));
            $count_product++;

            $cart[$cart_key] = $count_product;

            //$request->session()->forget('cart');
            $request->session()->put('cart', $cart); 

            $new_cart = array();
            foreach ($request->session()->get('cart') as $key => $value)
            {
              $new_cart[$key] = $value;
            }

            return $new_cart;
          }

          // Subtracting quantity from the cart
          if($operation == 'subtract')
          {
            $count_product = ((int)($cart[$cart_key]));
            $count_product--;

            if($count_product > 0)
            {
              $cart[$cart_key] = $count_product;

              $request->session()->put('cart', $cart);

            $new_cart = array();
            foreach ($request->session()->get('cart') as $key => $value)
            {
              $new_cart[$key] = $value;
            }

            return $new_cart;

              return $count_product;
            }
            else
              return 1;
          }
        }
      }

      return "No cart in session";
    }

    public function if_loggedin(Request $request)
    {
      if($request->ajax())
      {
        if(Auth::check())
          return 'yes';

        else
          return 'no';
      }
      else
        return 'no';
    }

    public function count(Request $request)
    {
      if($request->session()->has('cart'))
      {
        $cart = $request->session()->get('cart');

        $count = 0;
        foreach ($cart as $key => $value)
        {
          $count++;
        }

        return $count;
      }

      else
        return 0;
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
