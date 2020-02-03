<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest')->only(['admin_login']);
	}

	public function index()
	{
		$maxDays      = date('t'); // 3691142
		$year         = date("Y");
		$month        = date('m');

		$dates        = array();
		$price        = array();
		$transactions = array();


		$today = date('Y-m-d'); 

		//36401094
		for($i=1; $i<=$maxDays; $i++)
		{
		    $repeat = strtotime("-1 day",strtotime($today));
		    $today  = date('Y-m-d',$repeat);

		    $dates[$i] = $today;
		    $price[$i] = Order::where(['date'=>$today, 'pay_status'=>1])->sum('price');
		    $transactions[$i] = Order::where(['date'=>$today, 'pay_status'=>1])->count();
		}


		return view('admin.index')->with([
											'dates'        => array_reverse($dates),
											'price'        => $price,
											'transactions' => $transactions,
										]);
	}

    public function admin_login()
    {
    	return view('admin/admin_login');
    }
}
