<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductScore extends Model
{
    protected $table    = 'product_score';
    protected $fillable = ['product_id', 'score_id', 'score_value', 'user_id'];
}
