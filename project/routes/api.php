<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// header('Access-Control-Allow-Origin : *');
// header('Access-Control-Allow-Headers : Content-Type,X-Auth-Token,Authorization,Origin');
// header('Access-Control-Allow-Methods :GET, POST, PUT, DELETE, OPTIONS');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('api')->get('/user', 'Front\FrontendController@users');
 Route::middleware('api')->get('/allcategories', 'Front\CatalogController@categoriesapi');
 Route::middleware('api')->get('/category/{slug}', 'Front\CatalogController@categoryapi');
 Route::middleware('api')->get('category/{slug1}/{slug2}', 'Front\CatalogController@subcategoryapi');
 Route::middleware('api')->get('category/{slug1}/{slug2}/{slug3}', 'Front\CatalogController@childcategoryapi');
 Route::middleware('api')->get('/item/{slug}', 'Front\CatalogController@productapi');

Route::post('register', 'User\RegisterController@register');
Route::post('register-otp', 'User\RegisterController@registerOtp');
Route::post('resend-otp', 'User\RegisterController@resendOtp');
Route::post('login', 'User\LoginController@login');

Route::post('product/cat/sub/child', 'Api\ApiCategoryController@productAscategories');
Route::post('product/search/frontend', 'Api\ApiCategoryController@productSearch');

//wish list
Route::post('wish-list-store', 'Api\ApiOrderController@wishListStore');

//---order
Route::post('order/store', 'Api\ApiOrderController@store');

Route::get('reward-condition', 'Api\ApiOrderController@rewardCondition');

Route::post('wish-list-store', 'Api\ApiOrderController@rewardCondition');