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
    return view('welcome');
});

//\Illuminate\Support\Facades\Auth::routes();
Route::get('/login', 'Auth\Custom\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('/login', 'Auth\Custom\LoginController@login')->middleware('guest');

Route::get('/register', 'Auth\Custom\RegisterController@create')->name('register');
Route::post('/register', 'Auth\Custom\RegisterController@store');

Route::post('/logout', 'Auth\Custom\LoginController@logout')->name('logout');


//USER MAIN ROUTES GOES HERE
Route::middleware(['auth'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');

    //ADMIN ROUTES GOES HERE
    Route::middleware([\App\Http\Middleware\CheckLevel::class])->group(function (){
        Route::get('/admin', 'Admin\DashboardController@index');

        //ADMIN USERS GOES HERE
        Route::get('/admin/users', 'Admin\UserController@index');
        Route::get('/admin/users/view/{id}', 'Admin\UserController@show');
        Route::get('/admin/users/edit/{id}', 'Admin\UserController@edit');
        Route::post('/admin/users', 'Admin\UserController@store');
        Route::put('/admin/users/{id}', 'Admin\UserController@update');
        Route::delete('/admin/users/delete/{id}', 'Admin\UserController@destroy');

        //ADMIN PRODUCTS GOES HERE
        Route::get('/admin/products', 'Admin\ProductController@index');
        Route::get('/admin/products/view/{id}', 'Admin\ProductController@show');
        Route::get('/admin/products/edit/{id}', 'Admin\ProductController@edit');
        Route::post('/admin/products', 'Admin\ProductController@store');
        Route::put('/admin/products/{id}', 'Admin\ProductController@update');
        Route::delete('/admin/products/delete/{id}', 'Admin\ProductController@destroy');

        //ADMIN SALES GOES HERE
        Route::get('/admin/sales', 'Admin\SalesController@index');
        Route::get('/admin/sales/view/{id}', 'Admin\SalesController@show');
        Route::get('/admin/sales/edit/{id}', 'Admin\SalesController@edit');
        Route::post('/admin/sales', 'Admin\SalesController@store');
        Route::put('/admin/sales/{id}', 'Admin\SalesController@update');
        Route::delete('/admin/sales/delete/{id}', 'Admin\SalesController@destroy');

    });
});


