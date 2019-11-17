<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin/feature/index');
    }

    public function create(Request $request)
    {
    	return 'create';
    }
}
