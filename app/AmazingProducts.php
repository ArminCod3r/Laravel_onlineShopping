<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmazingProducts extends Model
{
    protected $table = 'amazing_products';
    public $primaryKey = 'id';
    protected $fillable = ['short_title','long_title','description','price','price_discounted','product_id', 'time_amazing', 'time_amazing_timestamp'];
    public $timestamps = false;


    public function ProductImage()
    {
    	// Not 'hasMany' : We want just the first image
    	return $this->hasOne(ProductImage::class, 'product_id', 'product_id');
    }

    public function Product_details()
    {
    	return $this->hasOne(Product::class, "id", "product_id");
    }
}
