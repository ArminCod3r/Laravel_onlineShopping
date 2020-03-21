<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Statistics;
use DB;

class StatisticsController extends Controller
{
	public function stat()
    {
    	$views = Statistics::fetch_statistics();

		$yearly_view  = Statistics::total_view_of(date("Y"), null, null);
		$monthly_view = Statistics::total_view_of(date("Y"), date("n"), null);
		$daily_view   = Statistics::total_view_of(date("Y"), date("n"), date("d"));


    	return view('admin/statistics/stat')->with([
    												'views'        => $views,
    												'yearly_view'  => $yearly_view,
    												'monthly_view' => $monthly_view,
    												'daily_view'   => $daily_view,
    												]);
    }
}
