<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    protected $table = 'category';
    public $primaryKey = 'id';
    protected $fillable = ['cat_name','cat_ename','parent_id','img'];
    public $timestamps = false;

    // database -> where 'parent_id' == 'id'
    // relation: one-to-many
    // why?
    // Because each category can have multiple sub-category
    //
    public function getChild()
    {
    	return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function getParent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id')->withDefault(['cat_name'=>'-']);
    }

    public function Feature()
    {
        return $this->hasMany(Feature::class, 'category_id', 'id');
    }
}
