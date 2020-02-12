<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HierarchieFilter extends Model
{
    protected $table = 'hierarchie_filter';
    public $primaryKey = 'id';
    protected $fillable = ['name', 'ename', 'parent_id','category_id', 'filled'];
    public $timestamps = false;

    public function get_childs()
    {
    	return $this->hasMany(HierarchieFilter::class, 'parent_id', 'id');
    }
}
