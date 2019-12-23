<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'color_product';
    public $primaryKey = 'id';
    protected $fillable = ['id','color_code','product_id'];
    public $timestamps = false;
}
