<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('check_username', function($attribute, $value, $parameters)
        {
            //code that would validate
            //attribute its the field under validation
            //values its the value of the field
            //parameters its the value that it will validate againts 
            if(filter_var($value, FILTER_VALIDATE_EMAIL))
                return true;
            else
            {
                $val_len = strlen($value);

                if($val_len == 10)
                {
                    if(substr($value, 0, 1) == '9')
                        return true;
                }
                
                else
                {
                    if($val_len == 11)
                        if(substr($value, 0, 2) == '09' )
                            return true;

                    else
                        return false;
                }
            }
        });

        Validator::extend('unique_username', function($attribute, $value, $parameters)
        {
            $user = DB::table('users')->where('username', $value)->first();

            if($user)
                return false;
            else
                return true;
        });

        Validator::extend('check_captcha', function($attribute, $value, $parameters)
        {
            $captcha = \Session::get('Captcha');

            if($value == $captcha)
                return true;
            else
                return false;
        });
    }
}
