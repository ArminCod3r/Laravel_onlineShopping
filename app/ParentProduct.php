<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ParentProduct extends Model
{
    protected $table = 'parent_product';
    public $primaryKey = 'id';
    protected $fillable = ['product_id','parent_id','created_at','updated_at'];
    public $timestamps = true;
}
