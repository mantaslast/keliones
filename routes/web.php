<?php

use Illuminate\Support\Facades\Route;
use App\Mail\ReservationSuccessfull;

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

//SuperAdmin routai su prefixu admin
Route::group(['middleware' => ['auth', 'superAdmin'], 'prefix' => 'admin'], function () {
    // Useriams
    Route::get('/users/r/{role?}', 'WEB\superAdmin\users\UserController@index')->name('superAdminUsers');
    Route::get('/users/{user}', 'WEB\superAdmin\users\UserController@show')->name('superAdminUser');
    Route::get('/users/{user}/edit', 'WEB\superAdmin\users\UserController@edit')->name('superAdminUserEditForm');
    Route::delete('/users/{user}', 'WEB\superAdmin\users\UserController@destroy')->name('superAdminUser');
    Route::put('/users/{user}', 'WEB\superAdmin\users\UserController@update')->name('superAdminUserUpdate');
    Route::get('/orders', 'WEB\superAdmin\orders\OrdersController@index')->name('superAdminOrders');
    Route::get('/orders/{order}', 'WEB\superAdmin\orders\OrdersController@show')->name('superAdminOrder');
    Route::put('/orders/{order}', 'WEB\superAdmin\orders\OrdersController@update')->name('superAdminOrderUpdate');
});

//Admino routai su prefixu /admin
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/','WEB\admin\AdminController@index')->name('adminIndex');
    Route::resource('categories', 'WEB\admin\categories\CategoriesController');
    Route::resource('offers', 'WEB\admin\offers\OffersController');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', 'WEB\user\ProfileController@index')->name('profile');
});

Route::get('/paieska', 'WEB\shop\SearchController@search')->name('search');

Route::group(['prefix' => 'rezervacija'], function () {
    //Rezervacija
    Route::post('/naujas', 'Web\shop\ReservationController@store')->name('reservation.store');
    Route::get('/sekminga-rezervacija', 'WEB\shop\ReservationController@success')->name('reservation.success');
    Route::get('/{offer}', 'WEB\shop\ReservationController@create')->name('reservation');
    Route::get('/ord/{order}', 'WEB\shop\ReservationController@show')->name('reservation.show');
});


//Public routai shop
Route::get('/', 'WEB\IndexController@index')->name('home');
Route::get('/{category}/{offer}', 'WEB\shop\MainController@index')->name('offer');
Route::get('/{category}', 'WEB\shop\CategoryController@index')->name('category');