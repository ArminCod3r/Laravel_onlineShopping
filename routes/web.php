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

Route::middleware(['throttle:60,1'])->group(function(){
	
	
	Route::middleware(['statistic'])->group(function(){
		// site's index/product/Cart pages
		Route::get('/', "SiteController@index");
		Route::get('product/{code}/{title_url}', 'SiteController@showProduct');
		Route::post('/cart', 'SiteController@cart');
		Route::get('/cart', 'SiteController@cart');
		Route::post('/cart/change', 'SiteController@cart_change');
		Route::post('/cart/count', 'SiteController@count');
	});

	Route::middleware(['check_admin'])->group(function(){
		// Admin's idnex
		Route::get('/admin', 'admin\AdminController@index');

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


		// Products' Filter
		Route::get('admin/filter' , 'admin\FilterController@index');
		Route::post('admin/filter', 'admin\FilterController@create');
		Route::get('admin/filter/list' , 'admin\FilterController@list');

		//Route::resource('admin/hierarchie', 'admin\HieraricheFilterController');
		Route::get('admin/hierarchie' , 'admin\HieraricheFilterController@index');
		Route::post('admin/hierarchie', 'admin\HieraricheFilterController@create');
		Route::get('admin/hierarchie/sub_adding', 'admin\HieraricheFilterController@sub_adding');

		Route::resource('admin/filter_assign', 'admin\FilterAssignController');
		// ---- override 'show/edit/update' route		
		Route::get('admin/filter_assign/show/{category_id}/{product_id}' , 'admin\FilterAssignController@show');
		Route::get('admin/filter_assign/{category_id}/{product_id}/edit' , 'admin\FilterAssignController@edit');
		Route::patch('admin/filter_assign/{category_id}/{product_id}' , 'admin\FilterAssignController@update');

		Route::get('admin/filter/in_what_categories/{product_id?}/{category_id?}' , 'admin\FilterController@in_what_categories');

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


		// state
		Route::resource('admin/state','admin\StateController');

		// city
		Route::resource('admin/city','admin\CityController');

		// Order managing
		Route::resource('admin/order','admin\OrderController');

		// User
		Route::resource('admin/user','admin\UserController');

	});

	// Admin login
	Route::get('admin_login','admin\AdminController@admin_login');



	Route::get('/categoryTree', "SiteController@categoryTree");


	// Auth
	Auth::routes();

	Route::get('/home', 'HomeController@index')->name('home');


	// Captcha
	Route::get('captcha', function(){

		$captcha = new \App\Lib\Captcha();
		$captcha->create();

	});

	Route::post('if_loggedin', 'SiteController@if_loggedin');


	// shipping

	// ---- shipping's review
	Route::post('/shipping/review', 'ShippingController@review');
	Route::get('/shipping/review', 'ShippingController@review');

	// ---- payment	
	Route::get('shipping/payment', 'ShippingController@payment');
	Route::post('shipping/payment', 'ShippingController@payment');
	Route::get('shipping/payment/cash-on-delivery/{id}', 'ShippingController@cashOnDelivery');

	Route::resource('/shipping','ShippingController');
	Route::post('/shipping/ajax_view_cities','ShippingController@ajax_view_cities');
	// ---- store shipping Address
	Route::post('/shipping/storeAddress','ShippingController@storeAddress'); 
	// ---- edit shipping Address
	Route::PATCH('/shipping/updateAddress/{Address}','ShippingController@updateAddress')
			->name('shipping.updateAddress');
	// ---- delete shipping Address		
	Route::delete('shipping/{Address}/destroyAddress', 'ShippingController@destroyAddress')
		 ->name('shipping.destroyAddress');


	// Searching
	/*Route::get('/search/{cat1?}/{cat2?}/{cat3?}/{cat4?}', function($cat1=null, $cat2=null, $cat3=null, $cat4=null){
		return [$cat1, $cat2, $cat3, $cat4];
	});*/
	Route::get('/search/{cat1?}/{cat2?}/{cat3?}/{cat4?}', 'SearchController@search');

	
	Route::middleware('auth')->group(function(){

		// Products' comments
		Route::post('comment/store_score/{product_id}'  , 'CommentController@store_score')->name('comment.store_score');
		Route::GET('comment/store_comment/{product_id}', 'CommentController@store_comment')->name('comment.store_comment');
		Route::resource('comment','CommentController');

		// Products' question
		Route::resource('question','QuestionController');
	});
	
	Route::post('comment/ajax_fetch_comments/', 'CommentController@ajax_fetch_comments');
	Route::post('question/ajax_fetch_questions/', 'QuestionController@ajax_fetch_questions');
});
