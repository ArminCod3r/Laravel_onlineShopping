<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Category;
use View;
use DB;
use \Illuminate\Http\Request;
use URL;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    private $categories = array();

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $maxAttempts  = '5';
    protected $decayMinutes = '1';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $categories = self::categoryTree();
        View::share('categories', $categories);
    }

    public function username()
    {
        return 'username';
    }


    protected function credentials(Request $request)
    {
        $arr = $request->only($this->username(), 'password');

        $prev_url = URL::previous();

        if( $prev_url == url('admin_login') )
            $arr['role'] = 'admin';

        else
            $arr['role'] = 'user';

        return $arr;
    }

    // Redirect users base on their roles
    public function redirectPath()
    {
        $role = Auth::user()->role;

        if( $role == 'admin')
            return 'admin';

        if( $role == 'role')
            return '/';
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
