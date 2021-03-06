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
		// https://laravel.com/docs/5.8/queries#joins
		$result = DB::table('category')
                ->join('parent_product', 'category.id', '=', 'parent_product.parent_id')
                ->select('category.cat_name', 'category.id')
                ->where('product_id',$id)
                ->get()
                ->pluck('cat_name','id');
                //->toArray() // DB::table('tbl')->get() will return a collection of stdClass.
                		     // stdClass has no function toArray() [stack:47204041]
                //->makeHidden(['category.cat_name']);

		return $result; //var_dump($result);
    }

    public static function getColor($id = null)
    {
        if ($id == null)
        {
            $result = DB::table('product')
                ->join('color_product', 'product.id', '=', 'color_product.product_id')
                ->select('color_product.color_code', 'color_product.product_id')
                ->get()
                ->toArray();

            return $result;
        }

        else
        {
            $result = DB::table('product')
                ->join('color_product', 'product.id', '=', 'color_product.product_id')
                ->select('color_product.color_code')
                ->where('product.id',$id)
                ->pluck('color_code');
        }

        return $result;
    }

    // Put keyword in an array
    public static function keywords_trimming($keywords)
    {
        $keywords = explode(',', $keywords);

        $keywords_temp=array();
        foreach ($keywords as $key => $item)
        {
            if (!empty($item))
            {
                $keywords_temp[$key] = $item;
            }
        }
        return $keywords_temp;
    }

    // index > search
    public static function searchProduct($product)
    {
        $result = DB::table('product')
                ->select('*')
                ->where('product.title', 'like', '%'.$product.'%')
                ->paginate(5);

        return $result;
    }

    public function ProductImage()
    {
        return $this->hasMany("App\ProductImage");
    }

    public function color_product_frontend()
    {
        return $this->hasMany(Color::class, 'product_id', 'id');
    }

    public function Review()
    {
        return $this->hasOne(Review::class, 'product_id', 'id');
    }




    public static function ProductID_To_CategoryName($id)
    {
        /* Join 3 tables
           Query:
            --------------------
            1.
            SELECT *
            FROM product

            join parent_product
            on product.id = parent_product.product_id

            join category
            on parent_product.parent_id=category.id

            where product.id=28

            ----------- OR ----------
            2.
            select *
            from category
            where id IN (
                    select parent_id
                    from parent_product
                    where product_id IN (
                                        select id
                                        from product
                                        where id=28
                                        )
                    )
        */


        $result = DB::table('product')

                ->join('parent_product', 'product.id', '=', 'parent_product.product_id')
                ->join('category', 'parent_product.parent_id', '=', 'category.id')

                ->where('product_id',$id)
                //->where('category.id', '=', 'category.parent_id')

                ->get()
                ->toArray();


        return $result;
    }
}
