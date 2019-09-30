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

Route::get('/', function () {
    return view('welcome');
});

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