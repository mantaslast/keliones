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

//Public routai shop
Route::get('/', function () {
    return view('shop.home');
})->name('home');

Route::get('/deal', function() {
    return view('shop.deal');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', 'WEB\user\ProfileController@index')->name('profile');
});

//Admino routai su prefixu /admin
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/','WEB\admin\AdminController@index')->name('adminIndex');
    Route::resource('categories', 'WEB\admin\categories\CategoriesController');
    Route::resource('offers', 'WEB\admin\offers\OffersController');

});

//SuperAdmin routai su prefixu admin
Route::group(['middleware' => ['auth', 'superAdmin'], 'prefix' => 'admin'], function () {
    // Useriams
    Route::get('/users/r/{role?}', 'WEB\superAdmin\users\UserController@index')->name('superAdminUsers');
    Route::get('/users/{user}', 'WEB\superAdmin\users\UserController@show')->name('superAdminUser');
    Route::get('/users/{user}/edit', 'WEB\superAdmin\users\UserController@edit')->name('superAdminUserEditForm');
    Route::delete('/users/{user}', 'WEB\superAdmin\users\UserController@destroy')->name('superAdminUser');
    Route::put('/users/{user}', 'WEB\superAdmin\users\UserController@update')->name('superAdminUserUpdate');
});