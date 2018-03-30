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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/product/list', 'ProductController@list')->name('product.list');
    Route::get('/product/list/get', 'ProductController@getList')->name('product.list.get');
    Route::get('/product/list/add', 'ProductController@addProduct')->name('product.list.add');
    Route::post('/product/list/add-process', 'ProductController@addProductProcess')->name('product.list.addProcess');
    Route::post('/product/list/update', 'ProductController@updateProduct')->name('product.list.update');
    Route::post('/product/list/delete', 'ProductController@deleteProduct')->name('product.list.delete');
    Route::post('/product/detail/upload-file', 'ProductController@uploadFile')->name('product.detail.uploadFile');
    Route::post('/product/detail/remove-file', 'ProductController@removeFile')->name('product.detail.removeFile');

    Route::get('/product/detail/{id}', 'ProductController@getDetail')->name('product.detail.get');
});

Route::get('/login', 'Auth\LoginController@index')->name('auth.login');
Route::post('/login', 'Auth\LoginController@loginProcess')->name('auth.login.process');
Route::post('/logout', 'Auth\LoginController@logOut')->name('auth.logout');
Route::get('/password/reset', 'Auth\ForgotPasswordController@index')->name('password.request');
