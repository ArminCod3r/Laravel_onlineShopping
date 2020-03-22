<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductScore;
use App\ProductComment;
use App\Category;
use View;
use Auth;
use Validator;

class CommentController extends Controller
{

    public function __construct()
    {
        $categories = Category::all();
        $categories = json_decode($categories, true);

        View::share('categories', $categories);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store_score(Request $request, $id)
    {
        // Getting sent values
        $product = Product::findOrFail($id);
        $scores  = $request->get('score');

        // Verification
        if(is_array($scores))
        {
            // Duplication checking
            $is_duplicate = ProductScore::where(['user_id'=> Auth::user()->id, 'product_id'=>$id])->get();

            if( sizeof($is_duplicate) == 0 )               
            {
                // Store into the database
                foreach ($scores as $key => $item)
                {
                    $score = new ProductScore;

                    $score->product_id  = $id;
                    $score->score_id    = $key;
                    $score->score_value = $item;
                    $score->user_id     = Auth::user()->id;

                    $score->save();
                }
                return $this->show($id);
            }
            else
                return redirect()->back();
            
        }
        else
            return redirect()->back();
    }

    public function store_comment(Request $request, $id)
    {
        // Validator for the subject
        $rules = [ 'title'    => 'required' ];
        $msg   = [ 'required' => ':attribute الزامی است' ];
        $field = [ 'title'    => 'عنوان نقد و بررسی ' ];

        $validator = Validator::make($request->all(), $rules, $msg, $field);

        if($validator->fails())
            return $validator->validate();


        $product      = Product::findOrFail($id);
        $title        = $request->get('title');
        $pros         = $request->get('pros');
        $cons         = $request->get('cons');
        $comment_text = $request->get('comment_text');

        $pros_custom_string = "";
        $cons_custom_string = "";

        // Duplication checking
        $is_duplicate = ProductComment::where(['user_id'=> Auth::user()->id, 'product_id'=>$id])->get();

        if( sizeof($is_duplicate) == 0 ) 
        {
            // Verifications
            if( is_array($pros) or is_array($cons) )
            {
                // Makeing custom string of pros/cons 

                // if only 'pros' added
                if (is_array($pros))
                 {
                    foreach ($pros as $key => $value)
                    {
                        $pros_custom_string = $value."-::-".$pros_custom_string;
                    }
                 }

                // if only 'cons' added
                if (is_array($cons))
                {
                    foreach ($cons as $key => $value)
                    {
                        $cons_custom_string = $value."-::-".$cons_custom_string;
                    }
                }

                // Storing into the database
                $comment = new ProductComment();

                $comment->product_id   = $id;
                $comment->user_id      = Auth::user()->id;
                $comment->subject      = $title;
                $comment->pros         = $pros_custom_string;
                $comment->cons         = $cons_custom_string;
                $comment->comment_text = $comment_text;
                $comment->status       = 0;

                if($comment->save())
                    return $this->show($id);

                else
                    return redirect(url()->previous());
            }
            else
                return redirect(url()->previous());
        }

        else
            return redirect(url()->previous());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with("ProductImage")->findOrFail($id);
        $score   = ProductScore::where(['user_id'=> Auth::user()->id, 'product_id'=>$id])->get();
        $comment = ProductComment::where(['user_id'=> Auth::user()->id, 'product_id'=>$id])->get();

        return view("site.comment.show")->with([
                                                'product' => $product,
                                                'score'   => $score,
                                                'comment' => $comment,
                                              ]);
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

    public function ajax_fetch_comments(Request $request)
    {
        $product_id = $request->get('product_id');

        // 'group_by' the table by 'user_id' to loop over easier
        $scores   = ProductScore::with('User')->where('product_id', $product_id)->get()->groupBy('user_id');
        $comments = ProductComment::where('product_id', $product_id)->get()->groupBy('user_id');

        // Average score
        $avg = array();
        $avg[1] = 0;
        $avg[2] = 0;
        $avg[3] = 0;
        $avg[4] = 0;
        $avg[5] = 0;
        $avg[6] = 0;
        $count  = 0;

        $all_scores   = ProductScore::where('product_id', $product_id)->get();

        foreach ($all_scores as $key => $value)
        {
            if(array_key_exists($value->score_id, $avg))
            {
                $avg[$value->score_id] = $value->score_value + $avg[$value->score_id];
                $count++;
            }
        }

        foreach ($avg as $key => $value)
        {
            if($value>0)
                $avg[$key] = $value / ($count/6);
        }

        return view("include.comments_list")->with([
                                                    'comments'   => $comments,
                                                    'scores'     => $scores,
                                                    'average'    => $avg, 
                                                    'product_id' => $product_id,
                                                   ])
                                            ->render();
    }
}
