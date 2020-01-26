<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRow extends Model
{
    protected $table = 'order_row';
    public $primaryKey = 'id';
    protected $fillable = ['order_id','product_id','color_id','service_id','number'];
    public $timestamps = true;
}
