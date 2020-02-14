<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkCatFilter extends Model
{
    protected $table    = 'link_category_filter';
    public $primaryKey  = 'id';
    protected $fillable = ['category_id','filter_id', 'name'];
    public $timestamps  = false;
}
