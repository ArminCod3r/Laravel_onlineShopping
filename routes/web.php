<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// site's index/product page
Route::get('/', "SiteController@index");
Route::get('product/{code}/{title_url}', 'SiteController@showProduct');

// Admin's idnex
Route::get('admin', function () {
    return view('admin.index');
});

// Category
Route::resource('admin/category','admin\CategoryController');

// Slider
Route::resource('admin/slider','admin\SliderController');

// Product
Route::resource('admin/product', 'admin\ProductController');
Route::get('admin/product/gallery/{id}', 'admin\ProductController@gallery');
Route::post('admin/product/upload/{id}', 'admin\ProductController@upload');
Route::delete('admin/product/deleteImage/{img}', 'admin\ProductController@deleteImage');
// Except 'delete', Drop all other methods (stack:18326030)
Route::match(array('GET', 'POST', 'HEAD', 'PUT', 'PATCH'), 'admin/product/deleteImage/{img}', function()
{
    return abort(404);
});

Route::get('/categoryTree', "SiteController@categoryTree");

// Products' Filter
Route::get('admin/filter' , 'admin\FilterController@index');
Route::post('admin/filter', 'admin\FilterController@create');

// Products' Features
Route::get('admin/feature' , 'admin\FeatureController@index');
Route::post('admin/feature', 'admin\FeatureController@create');
Route::get('admin/feature/list', 'admin\FeatureController@list');
Route::get('admin/feature/{product_id}/add', 'admin\FeatureController@add');
Route::get('admin/feature/{product_id}/{category_id}/add', 'admin\FeatureController@add');
Route::post('admin/feature/{product_id}/feature_assign', 'admin\FeatureController@feature_assign');


// Amazin Products
Route::resource('admin/amazing_products','admin\AmazingProductController');

// Review
//Route::resource('admin/review/{product_id}','admin\ReviewController');
Route::get('admin/review','admin\ReviewController@index')
	 ->name('review.index');

Route::get('admin/review/{product_id}/create','admin\ReviewController@create' )
	 ->name('review.create');

Route::delete('admin/review/{product_id}/destroy', 'admin\ReviewController@destroy')
	 ->name('review.destroy');

Route::get('admin/review/{product_id}/show', 'admin\ReviewController@show')
	 ->name('review.show');

Route::patch('admin/review/{product_id}/update', 'admin\ReviewController@update')
	  ->name('review.update');

Route::get('admin/review/{product_id}/edit', 'admin\ReviewController@edit')
	  ->name('review.edit');
	  
Route::post('admin/review/store/{product_id}', 'admin\ReviewController@store')
	  ->name('review.store');

Route::post('admin/review/upload/{product_id}', 'admin\ReviewController@upload');

Route::delete('admin/review/deleteImage/{img}', 'admin\ReviewController@deleteImage');