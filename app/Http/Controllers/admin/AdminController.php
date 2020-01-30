<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest')->only(['admin_login']);
	}

    public function admin_login()
    {
    	return view('admin/admin_login');
    }
}
