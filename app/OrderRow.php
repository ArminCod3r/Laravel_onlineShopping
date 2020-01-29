<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRow extends Model
{
    protected $table = 'order_row';
    public $primaryKey = 'id';
    protected $fillable = ['order_id','product_id','color_id','service_id','number'];
    public $timestamps = true;

    public function product()
    {
    	return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function color()
    {
    	return $this->hasOne(Color::class, 'id', 'color_id');
    }

    public function image()
    {
    	return $this->hasOne(ProductImage::class, 'product_id', 'product_id');
    }
}
