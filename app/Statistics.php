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

    public static function fetch_statistics()
    {
        $year  = date("Y");
        $month = date("n");
        $day   = date("d");

        $days_of_current_month = date('t');  //3691142
        $views = array();

        for ($i=0 ; $i<=$days_of_current_month ; $i++)
        {
            $day = Statistics::where(['year'=>$year, 'month'=>$month, 'day'=>$i])->first();

            if($day)
                $views[$i] = $day->total_view;
            else
                $views[$i] = 0;
        }

        return $views;
    }

    public static function total_view_of($year=null, $month=null, $day=null)
    {
        $view;

        if( $year )
            $view = Statistics::where(['year'=>$year])->sum('total_view');

        if( $month )
            $view = Statistics::where(['year'=>$year, 'month'=>$month])->sum('total_view');

        if( $day )
            $view = Statistics::where(['year'=>$year, 'month'=>$month, 'day'=>$day])->sum('total_view');

        return $view;
    }
}
