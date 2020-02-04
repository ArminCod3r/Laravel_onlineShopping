<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterAssign extends Model
{
    protected $table = 'filter_assign';
    public $primaryKey = 'id';
    protected $fillable = ['filter_id','product_id', 'value', 'value_id'];
    public $timestamps = false;
}
