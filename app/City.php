<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    public $primaryKey = 'id';
    protected $fillable = ['name', 'state_id'];
    public $timestamps = false;
}
