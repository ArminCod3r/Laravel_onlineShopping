<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table    = 'question';
    protected $fillable = ['time', 'product_id', 'user_id', 'question', 'parent_id', 'status'];
    public $timestamps  = true;
}
