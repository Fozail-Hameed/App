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
// Route::get('/dashboard/{any}','HomeController@Dashboard')->where('any', '.*');
// Route::get('/profile/{any}','HomeController@Profile')->where('any', '.*');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

// Route::get('{any}', function () {
//     return view('home');
// })->where('any','.*');
// Route::get('{path}', 'HomeController@index')->where( 'path' , '([A-z\d\-\/_.]+)?' );
// Route::get('logout','HomeController@Logout')->name('logout');
Route::get('logout','HomeController@LogOut');
// 