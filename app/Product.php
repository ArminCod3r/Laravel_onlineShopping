<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    protected $table='product';
    protected $fillable=['title','code','title_url','code_url','price','discounts','view',
    					 'text','product_status','bon','show_product','product_number',
        				 'order_product','keywords','description','special'];
    public $timestamps=true;

    public static function getParent($id)
    {
    	/*$query = "select *
				  from category
			      where id IN (
					        select parent_id
					        from parent_product
					        where product_id =3
							)";
		$result = DB::select($query);*/

		// Google: database joins & SQL joins
		// https://www.w3schools.com/sql/sql_join.asp
		// https://stackoverflow.com/questions/29165410/how-to-join-three-table-by-laravel-eloquent-model
		$result = DB::table('category')
                ->join('parent_product', 'category.id', '=', 'parent_product.parent_id')
                ->select('category.cat_name')
                ->where('product_id',$id)
                ->get()->toArray();

		return $result; //var_dump($result);
    }
}
