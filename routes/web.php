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
// Route::prefix('backend')->middleware('auth')->group(function() {
// 	Route::get('/', function() {
// 		return view('admin.pages.blank');
// 	})->name('blank');
// 	Route::get('users/{user}', 'UserController@edit')->name('users.edit');
// 	Route::post('users/{user}', 'UserController@update')->name('users.update');
// });

Route::get('/', 'HomeController@getReceievedSMSList')->name('home');

Auth::routes();

Route::get('signout', function() {
	Auth::logout();
	return redirect(route('login'));
})->name('signout');
Auth::routes();

Route::get('/home', 'HomeController@getReceievedSMSList')->name('home');

Route::post('get-received-sms-lists', ['as'=>'search.received.sms-lists',  'uses' => 'HomeController@searchReceievedSMSList'
    ]);

