<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeatureAssign extends Model
{
    protected $table = 'feature_assign';
    public $primaryKey = 'id';
    protected $fillable = ['feature_id','product_id','value'];
    public $timestamps = false;
}
