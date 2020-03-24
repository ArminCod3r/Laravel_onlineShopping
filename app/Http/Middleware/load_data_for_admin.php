<?php

namespace App\Http\Middleware;

use Closure;
use App\ProductScore;
use App\ProductComment;
use App\Question;

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
        // Getting list of the unapproved comments and share it through the views (pass variable to the view)

        $unapproved_comments = ProductComment::where('status', 0)->with('ProductScore')->count();
        $unapproved_question = Question::where('status', 0)->count();

        view()->share([
                        'unapproved_comments' => $unapproved_comments,
                        'unapproved_question' => $unapproved_question,
                     ]);
        

        return $next($request);
    }
}
