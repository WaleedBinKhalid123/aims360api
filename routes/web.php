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
	Route::get('/dashboard','DashboardController@show')->name('Dashboard');
	//Route::post('/import/submit','App\Http\Controllers\ImportProductsController@import')->name('Import_Data');
	//Route::get('export','App\Http\Controllers\ExportProductsController@export')->name('Export');
	//Route::post('/import/product','App\Http\Controllers\ImportProductsController@add')->name('Product');
	//Route::post( '/getproduct','App\Http\Controllers\ImportProductsController@get');
	//Route::get( '/delproduct','App\Http\Controllers\ImportProductsController@del');
	//Route::get('import/getProduct','App\Http\Controllers\ImportProductsController@edit');
	Route::get('/sh_products','ShipHeroController@index')->name('SH_Products');
	Route::get('/sh_products-loadData','ShipHeroController@loadData')->name('sh_loaddata');
	Route::post('/ship_hero_product_get','ShipHeroController@getProduct');
	Route::get('sh_products/submit','ShipHeroController@editProduct')->name('EditProduct');
    Route::get('ship_hero_product_delete','ShipHeroController@deleteProduct')->name('DeleteProduct');
    Route::get('a360_products','Aims360Controller@index')->name('A360_Products');
    Route::post('/aims360_product_get','Aims360Controller@getProduct');
    Route::get('A360_products/submit','Aims360Controller@editProduct');
    Route::get('aims360_product_delete','Aims360Controller@deleteProduct');
    Route::get('fetch_ship_hero_product','ShipHeroController@fetchShipHeroProducts')->name('fetch_ship_hero_product_modal');
    Route::post('match_products','ShipHeroController@matchProducts');
    Route::get('/aims360_products-loadData','Aims360Controller@loadData')->name('aims360_loaddata');
    Route::get('match_products','MatchProductController@index')->name('Match_Products');
    Route::post('unmatch_products','MatchProductController@unMatchProduct')->name('UnMatch_Products');
    Route::get('/matchProducts-loadData','MatchProductController@loadMatchProducts')->name('MP_loaddata');


});

/*Route::get('/Aim360Styles', function (\App\Http\Services\Aims360\AimsStyleService $authenticationService) {
    dd($authenticationService->getAims360Styles());
});*/
