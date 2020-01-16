<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
    public $primaryKey = 'id';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function City()
    {
    	return $this->hasMany(City::class, 'state_id', 'id');
    }
}
