<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersAddress extends Model
{
    protected $table = 'users_address';
    public $primaryKey = 'id';
    protected $fillable = ['user_id','username','state_id','city_id','telephone','city_code','mobile','postalCode','address'];
    public $timestamps = false;


    public function State()
    {
    	return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function City()
    {
    	return $this->hasOne(City::class, 'id', 'city_id');
    }
}
