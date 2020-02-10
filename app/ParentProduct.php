<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ParentProduct extends Model
{
    protected $table = 'parent_product';
    public $primaryKey = 'id';
    protected $fillable = ['product_id','parent_id','created_at','updated_at'];
    public $timestamps = true;
    
    public function Product()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
    
    public function ProductImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'product_id');
    }
    
    public function FilterAssign()
    {
        return $this->hasMany(FilterAssign::class, 'product_id', 'product_id');
    }
}
