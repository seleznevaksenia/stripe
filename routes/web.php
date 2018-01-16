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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



//Product
Route::get('/products/{id}/edit', 'ProductController@edit')->name('edit');
//Sku
Route::get('/products/create/{id}', 'ProductController@createSku')->name('createSku');
Route::post('/products/sku/{id}', 'ProductController@storeSku')->name('storeSku');
Route::get('/products/sku/{skuId}', 'ProductController@showSku')->name('showSku');
Route::put('/products/sku/{skuId}', 'ProductController@updateSku')->name('updateSku');
Route::delete('/products/sku/{skuId}', 'ProductController@deleteSku')->name('deleteSku');

//Product
Route::get('/products/create', 'ProductController@create')->name('create');
Route::delete('/products/{id}', 'ProductController@delete')->name('delete');
Route::get('/products/{id}', 'ProductController@show')->name('show');
Route::put('/products/{id}', 'ProductController@update')->name('update');
Route::get('/products', 'ProductController@index')->name('index');
Route::post('/products', 'ProductController@store')->name('store');

//Cart
Route::post('/cart/create/{skuId}', 'CartController@addToCart')->name('addToCart');
Route::delete('/cart/{uid}', 'CartController@delete')->name('deleteOrderItem');
Route::post('/cart/checkout', 'CartController@create')->name('createOrder');
Route::get('/cart', 'CartController@index')->name('cart');

//Payments data
Route::get('/card', 'CardController@index')->name('indexCard');
Route::post('/card/create', 'CardController@create')->name('createCard');

//
Route::get('/success', function (){
    return view('cart.success');
})->name('success');
Route::get('/unsuccess', function (){
    return view('cart.unsuccess');
})->name('unsuccess');




