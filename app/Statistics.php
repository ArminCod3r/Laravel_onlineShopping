<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $table    = 'statistics';
    protected $fillable = ['year', 'month', 'day', 'view', 'total_view'];
    public $timestamps  = true;
}
