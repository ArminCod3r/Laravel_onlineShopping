<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $table = 'filter';
    public $primaryKey = 'id';
    protected $fillable = ['category_id','name','ename','img','parent_id','filled'];
    public $timestamps = false;
}
