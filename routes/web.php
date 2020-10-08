<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth/login');
})->middleware('guest');


Auth::routes();

Route::middleware('auth')->group(function() {
	Route::get('/import','App\Http\Controllers\ImportProductsController@show')->name('Import');
	Route::post('/import/submit','App\Http\Controllers\ImportProductsController@import')->name('Import_Data');
	Route::get('export','App\Http\Controllers\ExportProductsController@export')->name('Export');
	Route::post('/import/product','App\Http\Controllers\ImportProductsController@add')->name('Product');
	Route::post( '/getproduct','App\Http\Controllers\ImportProductsController@get');
	Route::get( '/delproduct','App\Http\Controllers\ImportProductsController@del');
	Route::get('import/getProduct','App\Http\Controllers\ImportProductsController@edit');
	Route::get('/sh_products','App\Http\Controllers\ApiController@index')->name('SH_Products');
	Route::post('/ship_hero_product_get','App\Http\Controllers\ApiController@getProduct');
	Route::get('sh_products/submit','App\Http\Controllers\ApiController@editProduct')->name('EditProduct');
    Route::get('ship_hero_product_delete','App\Http\Controllers\ApiController@deleteProduct')->name('DeleteProduct');
});

/*Route::get('/Aim360Styles', function (\App\Http\Services\Aims360\AimsStyleService $authenticationService) {
    dd($authenticationService->getAims360Styles());
});*/
