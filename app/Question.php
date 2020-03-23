<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;
use Auth;

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

    public static function remove_question($question_id)
    {
        $question = Question::findOrFail($question_id);

        if($question->parent_id == 0)
        {
            $childs_questions = Question::where('parent_id', $question->id);
            $childs_questions->delete();

            $question->delete();
            return true;
        }            

        else
            return false;
    }

    public static function admin_answer($request)
    {
        $product_id    = $request->get('product_id'); // $request->ALL('product_id'); output will be array
        $parent_id     = $request->get('parent_id');
        $product       = Product::findOrFail($product_id);
        $question_text = $request->get('question_text');

        $question = new Question;

        $question->time       = time();
        $question->product_id = $product_id;
        $question->user_id    = Auth::user()->id;
        $question->question   = $question_text;
        $question->parent_id  = $parent_id;
        $question->status     = 1;

        if($question->save())
            return true;
        else
            return false;
    }
}
