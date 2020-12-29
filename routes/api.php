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
    Route::post('orders/generateInvoice', 'Api\admin\OrdersController@generateInvoice');
});


Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    //Offers routes
    Route::post('offers/destroy', 'Api\admin\OffersController@destroy');
    Route::post('offers/generatePdf', 'Api\admin\OffersController@generatePdf');
    Route::post('offers/offerImage', 'Api\admin\OffersController@addOfferImage');
    Route::delete('offers/offerImage', 'Api\admin\OffersController@deleteOfferImage');
    Route::post('offers/getofferImages', 'Api\admin\OffersController@getOfferImage');
    //Orders routes
    Route::post('orders/generatePdf', 'Api\admin\OrdersController@generatePdf');
    //Categories routes
    Route::post('categories/destroy', 'Api\admin\CategoriesController@destroy');
    Route::post('categories/generatePdf', 'Api\admin\CategoriesController@generatePdf');
    //Users routes
    Route::post('users/destroy', 'Api\admin\UsersController@destroy');
    Route::post('users/generatePdf', 'Api\admin\UsersController@generatePdf');
    Route::post('reports', 'Api\admin\ReportsController@getData');
    Route::post('scrapperimports', 'Api\admin\ImportsController@parseScrapperCsv');
    Route::post('plainimports', 'Api\admin\ImportsController@parsePlainCsv');
    Route::post('storeScrappedImportedOffer', 'Api\admin\ImportsController@storeScrappedImportedOffer');
    Route::post('storePlainImportedOffer', 'Api\admin\ImportsController@storePlainImportedOffer');
    //Analytics dashboard
    Route::get('analytics', 'Api\admin\AnalyticsController@get');
});