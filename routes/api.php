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

Route::post('login', 'Auth\LoginController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function () {
    //Profile routes
    Route::apiResource('profile', 'API\ProfileController');
    Route::post('scrapper', 'Api\ScrapperController@get');
    Route::post('rating', 'Api\RatingsController@setRating');
});


Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    //Offers routes
    Route::post('offers/destroy', 'Api\admin\OffersController@destroy');
    Route::post('offers/generatePdf', 'Api\admin\OffersController@generatePdf');
    //PDF routes
    
});