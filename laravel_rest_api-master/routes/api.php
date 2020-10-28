<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
   // Route::post('order', 'OrderController@order');
  //  Route::get('/user/order/{id}','OrderController@getUserbyOrder');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');       
        Route::get('/','AuthUserController@CurrentActiveUser');
        
        //AuthUser Api
    
        Route::post('authuser/order', 'OrderController@AuthUserOrder');
       // Route::get('order/{id}', 'AuthUserController@ShowAuthOrderedList');
        Route::get('authuser/order/list', 'AuthUserController@ShowAuthOrderedList');
        Route::get('authuser/order/list/product-details/{id}', 'AuthUserController@ShowAuthOrderedListProductDetails');
        Route::delete('authuser/order/list/product-delete/{id}', 'AuthUserController@AuthUserOrderdSingleProductDelete');
        Route::get('authuser/order/full-list', 'AuthUserController@ShowUserOrderedFullList');


    });
   // Route::get('/home', 'HomeController@index')->name('home');
   //Route::get('user/order/list', 'AuthController@ShowUserOrderedList');
   
});
Route::Resource('/products','ProductController');
