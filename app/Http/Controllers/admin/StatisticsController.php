<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Statistics;

class StatisticsController extends Controller
{
	public function stat()
    {
    	$views = Statistics::fetch_statistics();

    	return $views;
    }
}
