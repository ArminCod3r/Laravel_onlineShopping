<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    public $primaryKey = 'id';
    protected $fillable = ['cat_name','cat_ename','parent_id','img'];
    public $timestamps = false;

    // database -> where 'id' == 'parent_id'
    // relation: one-to-many
    // why?
    // Because each category can have multiple sub-category
    //
    public function getChild()
    {
    	return $this->hasMany(Category::class, 'id', 'parent_id');
    }
}
