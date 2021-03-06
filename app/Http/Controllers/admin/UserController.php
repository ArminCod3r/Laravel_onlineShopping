<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Order;
use App\Http\Requests\UserRequest;
use Hash;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id','DESC')->paginate(10);

        return view("admin/users/index")->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin/users/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $role     = $request->input('role');

        $user = new User();

        $user->username = $username;
        $user->password = Hash::make($password);
        $user->role     = $role;

        $user->saveOrFail();

        return redirect('admin/user/'.$user->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user   = User::findOrFail($id);
        $orders = Order::where('user_id', $id)->orderBy('id', 'DESC')->get();

        return view('admin/users/show')->with([
                                               'user'   => $user,
                                               'orders' => $orders,
                                             ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin/users/edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $role     = $request->input('role');

        $user = User::findOrFail($id);

        $user->username = $username;
        $user->role     = $role;
        if(sizeof($password)>0)
            $user->password = Hash::make($password);

        if($user->update())
        {
            // 21004310
            Session::flash('message', 'ویرایش با موفقیت انجام شد.'); 
            return redirect('admin/user/'.$id.'/edit');
        }
        else
            return abort(404);
        
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
}
