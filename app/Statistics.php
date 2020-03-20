<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $table    = 'statistics';
    protected $fillable = ['year', 'month', 'day', 'view', 'total_view'];
    public $timestamps  = true;

    public static function adding($year, $month, $day)
    {
    	$stats = new Statistics();

        $stats->year       = $year;
        $stats->month      = $month;
        $stats->day        = $day;
        $stats->view       = "-";
        $stats->total_view = 1;

        if($stats->save())
        	return true;
        else
        	return false;
    }

    public static function increment_view($year, $month, $day)
    {
    	$total_view = Statistics::where(['year'=>$year, 'month'=>$month, 'day'=>$day])
    				->pluck('total_view')->first();

    	$total_view = $total_view + 1;

    	Statistics::where(['year'=>$year, 'month'=>$month, 'day'=>$day])
    				->update(['total_view'=>$total_view]);

        return true;
    }
}
