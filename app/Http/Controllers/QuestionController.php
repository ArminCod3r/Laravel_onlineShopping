<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Question;
use Validator;
use Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'hi';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [ 'question_text' => 'required' ];
        $msg   = [ 'required'      => ':attribute الزامی است' ];
        $field = [ 'question_text' => 'متن پرسش' ];

        $validator = Validator::make($request->all(), $rules, $msg, $field);

        if($validator->fails())
            return $validator->messages()->getMessages();

        else
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
            $question->status     = 0;

            if($question->save())
                return '1';
            else
                return '0';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax_fetch_questions(Request $request)
    {
        $product_id = $request->get('product_id');
        $questions  = Question::with('User')->where(['product_id'=>$product_id, 'status'=>1])->orderBy("id", "DESC")->get();
        // TODO: $questions groupBy('parent_id')

        return view("include.questions_list")->with(['product_id'=> $product_id, 'questions'=>$questions]);
    }
}
