<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductScore;
use App\Category;
use View;
use Auth;

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

        return view("site.comment.show")->with([
                                                'product' => $product,
                                                'score'   => $score
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
}
