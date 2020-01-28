<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
Use App\State;
Use App\City;
use Validator;
use App\UsersAddress;
use Auth;
use Session;
use App\Order;

class ShippingController extends Controller
{
    private $categories = array();

    public function __construct()
    {
        $this->middleware('auth');

        $categories = self::categoryTree();
        View::share('categories', $categories);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Session::get('cart',array());

        if(sizeof($cart) > 0)
        {
            $states = State::all();

            $user_id = Auth::user()->id;
            $user_address = UsersAddress::with('State')
                                        ->with('City')
                                        ->where('user_id', $user_id)
                                        ->get();

            return view("site/shipping/index")->with([
                                                      'states'       => $states,
                                                      'user_address' => $user_address
                                                    ]);
        }
        else
            return redirect("cart");
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
        //
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
    

    public function ajax_view_cities(Request $request)
    {
        if($request->ajax())
        {
            $state_id = $request->get('state');

            $state = State::findOrFail($state_id);

            if(!empty($state))
            {
                $cities = City::select(['id','name'])
                                ->where('state_id', $state_id)
                                ->get()
                                ->toJSON();

                if(!empty($state))
                {
                    return $cities;
                }

                else
                    return 0;
            }
            else
                return 0;
        }

        else
        {
            abort(404);
        }

    }

    public function storeAddress(Request $request)
    {
        //return $request->all();


        $validator = $this->cutomValidator($request, "");


        if ($validator->fails())
        {
            return $validator->messages()->toArray();
        }

        else
        {
            $users_address = new UsersAddress();

            $user_id = Auth::user()->id;
            $users_address->user_id = $user_id;
            $users_address->username = $request->input('username');
            $users_address->state_id = $request->input('state');
            $users_address->city_id = $request->input('city');
            $users_address->telephone = $request->input('telephone');
            $users_address->city_code = $request->input('city_code');
            $users_address->mobile = $request->input('mobile');
            $users_address->postalCode = $request->input('postalCode');
            $users_address->address = $request->input('address');


            //$users_address->save();

            if($users_address->save())
                return 'ok';

            else
                return 'error';
        }
    }

    public function updateAddress(Request $request, $id)
    {
        
        $validator = $this->cutomValidator($request, "_edit");


        if ($validator->fails())
        {
            return $validator->messages()->toArray();
        }

        else
        {
            $user_addr = UsersAddress::where([
                                            'id'=>$id,
                                            'user_id'=> Auth::user()->id,
                                        ])->first();

            if ($user_addr)
            {
                DB::table('users_address')->where([
                                                    'id'=>$id,
                                                    'user_id'=> Auth::user()->id,
                                                 ])
                                            ->update([
                                                'username'   => $request["username_edit"],
                                                'state_id'   => $request["state_edit"],
                                                'city_id'    => $request["city_edit"],
                                                'telephone'  => $request["telephone_edit"],
                                                'city_code'  => $request["city_code_edit"],
                                                'mobile'     => $request["mobile_edit"],
                                                'postalCode' => $request["postalCode_edit"],
                                                'address'    => $request["address_edit"],
                                                ]);

                return "ok";
            }
            else
                return "error";

        }
    }


    private function cutomValidator(Request $request, $edit)
    {
        $rules = [
                    'username'.$edit   => 'required|max:250',
                    'state'.$edit      => 'required|max:250',
                    'city'.$edit       => 'required|max:250',
                    'telephone'.$edit  => 'required|max:20',
                    'city_code'.$edit  => 'required|max:10',
                    'mobile'.$edit     => 'required|max:11',
                    'postalCode'.$edit => 'required|max:12',
                    'address'.$edit    => 'required',
                ];

        $customMessages = [
                    'required' => ':attribute الزامی است',
                ];

        $fieldsName=[
                    'username'.$edit   => 'نام و نام خانوادگی',
                    'state'.$edit      => 'استان',
                    'city'.$edit       => 'شهر',
                    'telephone'.$edit  => 'تلفن ثابت',
                    'city_code'.$edit  => 'کد شهر ',
                    'mobile'.$edit     => 'شماره موبایل',
                    'postalCode'.$edit => 'کد پستی ',
                    'address'.$edit    => 'آدرس ',
                ];


        return Validator::make($request->all(), $rules, $customMessages, $fieldsName);
    }

    public function destroyAddress($id)
    {
        $user_addr = UsersAddress::where([
                                            'id'=>$id,
                                            'user_id'=> Auth::user()->id,
                                        ])->first();

        if ($user_addr)
        {
            $del_user_addr = UsersAddress::where([
                                            'id'=>$id,
                                            'user_id'=> Auth::user()->id,
                                        ])->first();

            if ($del_user_addr)
            {
                $del_user_addr->delete();

                return 'ok';
            }
        }

        else
        {
            return 'ko';
        }
    }

    public function review(Request $request)
    {
        $method = $request->method();

        if( $method == 'POST')
        {
            $cart = Session::get('cart',array());

            if(sizeof($cart) > 0)
            {
                $shipping_addr =  $request->input('selected_shipping_addr', 0); //set default value
                $shipping_type =  $request->input('selected_shipping_type');

                $shipping_addr_db = UsersAddress::findOrFail($shipping_addr);

                if($shipping_addr && $shipping_type)
                {
                    // temprary saving data in the session untill
                    // the last step that will store into the database.
                    $shipping_data = array();

                    $shipping_data['addr'] = $shipping_addr;
                    $shipping_data['type'] = $shipping_type;

                    Session::put('shipping_data', $shipping_data);


                    if($request->session()->has('cart'))
                    {
                        $cart_details = self::cartDetails();

                        return view('site/shipping/review')
                                ->with([
                                       'cart'          => $request->session()->get('cart'),
                                       'cart_details'  => $cart_details,
                                       'shipping_data' => Session::get('shipping_data'),
                                       'shipping_addr' => $shipping_addr_db,
                                      ]);
                    }

                }

                else
                {
                    return redirect("shipping");
                }
            }
            else
            {
                return redirect("shipping");
            }
        }

        else
        {
            $cart_details = self::cartDetails();

            if( Session::has('cart') && Session::has('shipping_data') )
            {
                $addr_id = Session::get('shipping_data')['addr'];

                $shipping_addr = UsersAddress::findOrFail($addr_id);



                return view('site/shipping/review')->with([
                                          'cart'         => $request->session()->get('cart'),
                                          'cart_details' => $cart_details,
                                          'shipping_data' => Session::get('shipping_data'),
                                          'shipping_addr' => $shipping_addr,
                                        ]);
            }
            else
                return redirect("cart");

        }
    }

    private function cartDetails()
    {
        $cart_details = array();

        if(Session::has('cart'))
        {
            foreach (Session::get('cart') as $key => $value)
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

            return $cart_details;
        }

        else
            return redirect("cart");
    }

    public function payment(Request $request)
    {
        $method = $request->method();

        if($method == 'GET')
        {
            $cart = Session::get('cart',array());

            if(sizeof($cart) > 0)
            {
                if(Session::has('shipping_data'))
                {
                    return view("site/shipping/payment");
                }
            }

            else
            {
                return redirect("cart");
            }
        }

        if($method == 'POST')
        {
            $payment_type = $request->input('selected_payment_type');

            if(Session::has('cart') && Session::has('shipping_data'))
            {
                switch(true)
                {
                    case (int)$payment_type == 1:
                        return redirect()->back()->with('error', 'در دست ساخت');
                        break;

                    case (int)$payment_type == 2:
                        $order  = new Order();
                        $result = $order->order_insert(2);

                        if(array_key_exists('id', $result))
                        {
                            Session::forget('cart');

                            $url = url('/shipping/payment/cash-on-delivery')."/".$result['id'];
                            return redirect($url);
                        }
                        else
                        {
                            return redirect()->back()->with('error', 'خطا به وجو آمده');
                        }

                        break;

                    case (int)$payment_type == 3:
                        return redirect()->back()->with('error', 'در دست ساخت');
                        break;

                    default:
                        return redirect("shipping/payment");
                }
            }
            else
            {
                return redirect("cart");
            }
        }
              
    }

    public function cashOnDelivery($id)
    {
        return $id ;
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
