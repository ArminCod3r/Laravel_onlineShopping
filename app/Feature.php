<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'feature';
    public $primaryKey = 'id';
    protected $fillable = ['category_id','name','filled','parent_id'];

    public function get_childs()
    {
    	return $this->hasMany(Feature::class, 'parent_id', 'id');
    }

    public function Category()
    {
    	return $this->belongsTo(Category::class);
    }
}
