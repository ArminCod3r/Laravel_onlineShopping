<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatisticsUser extends Model
{
    protected $table    = 'statistics_user';
    protected $fillable = ['year', 'month', 'day', 'user_ip'];
    public $timestamps  = true;

    public static function user_existance($users_ip)
    {
    	$user_stat = StatisticsUser::where('user_ip', $users_ip)->first();

    	if($user_stat)
    		return true;
    	else
    		return false;
    }

    public static function adding($year, $month, $day, $users_ip)
    {
    	$insert_user = new StatisticsUser();

        $insert_user->year    = $year;
        $insert_user->month   = $month;
        $insert_user->day     = $day;
        $insert_user->user_ip = $users_ip;

        if( $insert_user->save() )
        	return true;        
        else
    		return false;
    }
}
