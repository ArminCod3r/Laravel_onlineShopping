<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'slider';
    public $primaryKey = 'id';
    protected $fillable = ['title', 'url', 'img'];
    public $timestamps = false;
}
