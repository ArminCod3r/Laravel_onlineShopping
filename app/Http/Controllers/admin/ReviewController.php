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
        $reviews = Review::with('Product')->get(); //reviews + products

        return view('admin/review/index')->with(['reviews'=> $reviews]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);

        // To access the ID of the images, NOT: ProductImage::where('tag', 'review')->pluck('url');
        $review_images = $product->ProductImage->where('tag', 'review'); 

        return view('admin/review/create')->with([
                                                  'product'       => $product,
                                                  'review_images' => $review_images,
                                                ]);
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

        return redirect('admin/review/'.$product_id.'/edit');
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
    public function edit($product_id)
    {
        $product_id = str_replace(' ', '-', $product_id); // Replaces all spaces with hyphens.
        $product_id = preg_replace('/[^A-Za-z0-9\-]/', '', $product_id); // Removes special chars.

        $product = Product::findOrFail($product_id);

        $review_images = $product->ProductImage->where('tag', 'review'); 

        $review = Review::where('product_id', $product_id)->first();


        return view('admin/review/edit')->with([
                                                'product'       => $product,
                                                'review_images' => $review_images,
                                                'review'        => $review
                                               ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        $product_id = str_replace(' ', '-', $product_id); // Replaces all spaces with hyphens.
        $product_id = preg_replace('/[^A-Za-z0-9\-]/', '', $product_id); // Removes special chars.

        // Updating
        $desc = $request->input('desc');
        Review::where('product_id', $product_id)->update(array('desc' => $desc));


        $product       = Product::findOrFail($product_id);
        $review_images = $product->ProductImage->where('tag', 'review'); 
        $review        = Review::where('product_id', $product_id)->first();

        return redirect('admin/review/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 1. row
        $review = Review::findOrFail($id);
        $review->delete();

        // 2. img
        $images = ProductImage::where('product_id', $review->product_id)
                              ->where('tag', "review")
                              ->pluck("url");
                              
        foreach ($images as $key => $item)
        {              
            $path = 'upload/'.$item;

            if(file_exists($path))
            {
                unlink($path);
            }
        }

        return redirect()->back();
        
    }

    public function upload(Request $request, $id)
    {
        $id = str_replace(' ', '-', $id); // Replaces all spaces with hyphens.
        $id = preg_replace('/[^A-Za-z0-9\-]/', '', $id); // Removes special chars.

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

    public function deleteImage($img)
    {
        $image = ProductImage::findOrFail($img);

        if ($image->url)
        {
            $path = 'upload/'.$image->url;            

            if(file_exists($path))
            {
                $image->delete();

                unlink($path);
            }
        }

        return redirect()->back();
    }
}
