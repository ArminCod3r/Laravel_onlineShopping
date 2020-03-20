<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatisticsUser extends Model
{
    protected $table    = 'statistics_user';
    protected $fillable = ['year', 'month', 'day', 'user_ip'];
    public $timestamps  = true;
}
