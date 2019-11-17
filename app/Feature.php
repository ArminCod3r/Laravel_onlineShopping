<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'feature';
    public $primaryKey = 'id';
    protected $fillable = ['category_id','name','filled','parent_id'];
}
