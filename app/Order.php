<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $primaryKey = 'id';
    protected $fillable = ['address_id','user_id','time','date','pay_type','pay_status','order_status','total_price','price','code1','code2','order_read'];
    public $timestamps = true;

    public function order_insert()
    {
    	return 'about to insert';
    }
}
