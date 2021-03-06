<?php

namespace App\Http\Middleware;

use Closure;
use App\StatisticsUser;
use App\Statistics;

class Statistic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $users_ip = $request->ip();

        $year  = date("Y");
        $month = date("n"); // n:1 , m:01 , F:Jan-Dec    3768072
        $day   = date("d");

        $user_stat = StatisticsUser::where('user_ip', $users_ip)->first();

        if(!$user_stat)
            StatisticsUser::adding($year, $month, $day, $users_ip);


        $stat = Statistics::where(['year'=>$year, 'month'=>$month, 'day'=>$day])->first();        
        if($stat)
        {
            Statistics::increment_view($year, $month, $day);
        }
        else
        {
            Statistics::adding($year, $month, $day);
        }


        return $next($request);
    }
}
