<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;
use App\Product;
use App\ProductImage;
use App\Http\Requests\ReviewRequest;
use DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('review')->where('desc', 'NOT YET') //->select('img')
                                             ->pluck('img');

        return $result[0];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);

        return view('admin/review/create')->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request, $product_id)
    {
        $review = new Review;

        $product_id = str_replace(' ', '-', $product_id); // Replaces all spaces with hyphens.
        $product_id = preg_replace('/[^A-Za-z0-9\-]/', '', $product_id); // Removes special chars.

        $review->product_id = $product_id;
        $review->desc       = $request->input('desc');

        $review->Save();
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

    public function upload(Request $request, $id)
    {
        $id = 28;

        $files = $request->file('file');

        $rules = array(
            'file' => 'image|max:1999',
        );       

        $fileName = time().(rand(10,1000)).'.'.$files->getClientOriginalExtension();
        
        // Set the return value for Dropzone
        if($files->move('upload', $fileName))
        {
            $product_img = new ProductImage;

            // escape special characters (14114411)
            $id = str_replace(' ', '-', $id); // Replaces all spaces with hyphens.
            $id = preg_replace('/[^A-Za-z0-9\-]/', '', $id); // Removes special chars.

            $product_img->product_id = $id;
            $product_img->url = $fileName;
            $product_img->tag = 'review';

            $product_img->Save();

            return 1;
        }
        else
            return 0;
    }
}
