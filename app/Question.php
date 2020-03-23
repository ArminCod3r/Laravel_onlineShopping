<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;

class Question extends Model
{
    protected $table    = 'question';
    protected $fillable = ['time', 'product_id', 'user_id', 'question', 'parent_id', 'status'];
    public $timestamps  = true;

    public function User()
    {
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Product()
    {
    	return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public static function update_status($question_id)
    {
    	$question = Question::findOrFail($question_id);

    	$question->status = 1;

    	if($question->save())
    		return true;
    	else
    		return false;
    }
}
