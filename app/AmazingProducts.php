<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmazingProducts extends Model
{
    protected $table = 'amazing_products';
    public $primaryKey = 'id';
    protected $fillable = ['short_title','long_title','description','price','price_discounted','product_id', 'time_amazing'];
    public $timestamps = false;
}
