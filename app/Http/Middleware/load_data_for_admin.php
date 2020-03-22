<?php

namespace App\Http\Middleware;

use Closure;
use App\ProductScore;
use App\ProductComment;

class load_data_for_admin
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
        $unapproved_comments = ProductComment::where('status', 0)->with('ProductScore')->count();

        view()->share('unapproved_comments', $unapproved_comments);

        return $next($request);
    }
}
