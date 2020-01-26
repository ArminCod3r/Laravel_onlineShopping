<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

class Order extends Model
{
    protected $table = 'order';
    public $primaryKey = 'id';
    protected $fillable = ['address_id','user_id','time','date','pay_type','pay_status','order_step','total_price','price','code1','code2','order_read'];
    public $timestamps = true;

    public function order_insert($pay_type)
    {
    	$this->address_id   = Session::get('shipping_data')['addr'];
    	$this->user_id      = Auth::user()->id;
    	$this->time         = time();
    	$this->date         = date('Y-m-d');
    	$this->pay_type     = $pay_type;
    	$this->pay_status   = 0;
    	$this->order_step   = 1;

    	// getting the price and discount
    	$price_details = $this->price_details();
    	
    	$this->total_price  = $price_details['total_price'];
    	$this->price        = $price_details['discounted_price'];

    	$this->order_read   = 1;

    	$this->save();


    	return 'inserted';
    }



    private static function price_details()
    {
    	$prices = array();

    	$prices['total_price']      = 0;
    	$prices['discounted_price'] = 0;

    	foreach (Session::get('cart') as $key => $value)
        {
            $product_id  = explode('-', $key)[0];
            $product     = Product::find($product_id, ['price', 'discounts']);

            $prices['total_price'] += $product['price'];
            $prices['discounted_price'] += ($product['price']-(($product['price']*$product['discounts'])/100));

        }

        return $prices;
    }
}
