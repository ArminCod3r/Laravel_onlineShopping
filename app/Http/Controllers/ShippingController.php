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
        $states = State::all();

        return view("site/shipping/index")->with('states', $states);
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

        $rules = [
                    'username'  => 'required|max:250',
                    'state'     => 'required|max:250',
                    'city'      => 'required|max:250',
                    'telephone' => 'required|max:20',
                    'city_code' => 'required|max:10',
                    'mobile'    => 'required|max:11',
                    'postalCode'=> 'required|max:12',
                    'address'   => 'required',
                ];

        $customMessages = [
                    'required' => ':attribute الزامی است',
                ];

        $fieldsName=[
                    'username'  => 'نام و نام خانوادگی',
                    'state'     => 'استان',
                    'city'      => 'شهر',
                    'telephone' => 'تلفن ثابت',
                    'city_code' => 'کد شهر ',
                    'mobile'    => 'شماره موبایل',
                    'postalCode'=> 'کد پستی ',
                    'address'   => 'آدرس ',
                ];


        $validator = Validator::make($request->all(), $rules, $customMessages, $fieldsName);


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
