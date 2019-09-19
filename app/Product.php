<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table='product';
    protected $fillable=['title','code','title_url','code_url','price','discounts','view',
    					 'text','product_status','bon','show_product','product_number',
        				 'order_product','keywords','description','special'];
    public $timestamps=false;
}
