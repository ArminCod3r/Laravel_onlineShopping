<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $table    = 'product_comment';
    protected $fillable = ['product_id', 'user_id', 'subject', 'pros', 'cons', 'comment_text'];
    public $timestamps  = false;

    public function ProductScore()
    {
    	return $this->hasMany(ProductScore::class, 'product_id', 'product_id');
    }
}
