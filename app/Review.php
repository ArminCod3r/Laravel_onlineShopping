<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table='review';
    protected $fillable=['product_id', 'desc'];
    public $timestamps=false;


    public function Product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
