<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductScore;

class ProductComment extends Model
{
    protected $table    = 'product_comment';
    protected $fillable = ['product_id', 'user_id', 'subject', 'pros', 'cons', 'comment_text'];
    public $timestamps  = false;

    public function ProductScore()
    {
    	return $this->hasMany(ProductScore::class, 'product_id', 'product_id');
    }

    public function Product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public static function update_status($comment_id)
    {
    	$response = false;

    	try
    	{
    		ProductComment::where("id", $comment_id)->update(['status'=>1]);
    		$response = true;
    	}
    	catch (Exception $e)
    	{
    	}

    	return $response;
    }

    public static function remove_comment($comment_id)
    {
        $comment = ProductComment::findOrFail($comment_id);

        if($comment->delete())
        {
            $scores = ProductScore::where(['product_id'=>$comment->product_id , 'user_id'=>$comment->user_id]);

            if($scores->delete())
                return true;

            else
                return false;
        }

        else
            return false;
    }
}
