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

    Route::get('/customer', 'CustomerController@index')->name('customer');
    Route::get('/customer/get', 'CustomerController@getCustomer')->name('customer.get');

    Route::get('/product/list', 'ProductController@list')->name('product.list');
    Route::get('/product/list/get', 'ProductController@getList')->name('product.list.get');
    Route::get('/product/list/add', 'ProductController@addProduct')->name('product.list.add');
    Route::post('/product/list/add-process', 'ProductController@addProductProcess')->name('product.list.addProcess');
    Route::post('/product/list/update', 'ProductController@updateProduct')->name('product.list.update');
    Route::post('/product/list/delete', 'ProductController@deleteProduct')->name('product.list.delete');

    Route::get('/product/detail/{id}', 'ProductController@getDetail')->name('product.detail.get');
    Route::get('/product/photo-detail/{id}', 'ProductController@getPhotoDetail')->name('product.photoDetail.get');

    Route::post('/product/image/upload', 'ProductController@imageUpload')->name('product.image.upload');
    Route::post('/product/image/remove', 'ProductController@remove')->name('product.image.remove');

    Route::get('/stock/list', 'StockController@list')->name('stock.list');

    Route::get('/config/bank-account', 'ConfigController@bankAccount');
    Route::get('/config/bank-account/get', 'ConfigController@getBankAccount')->name('config.bankAccount.get');
    Route::post('/config/bank-account/add', 'ConfigController@addBankAccount')->name('config.bankAccount.add');
    Route::post('/config/bank-account/edit', 'ConfigController@editBankAccount')->name('config.bankAccount.edit');
    Route::post('/config/bank-account/delete', 'ConfigController@deleteBankAccount')->name('config.bankAccount.delete');

    Route::get('/config/category', 'ConfigController@category');
    Route::get('/config/category/get', 'ConfigController@getCategory')->name('config.category.get');
    Route::post('/config/category/add', 'ConfigController@addCategory')->name('config.category.add');
    Route::post('/config/category/edit', 'ConfigController@editCategory')->name('config.category.edit');
    Route::post('/config/category/delete', 'ConfigController@deleteCategory')->name('config.category.delete');

    Route::get('/config/color', 'ConfigController@color');
    Route::get('/config/color/get', 'ConfigController@getColor')->name('config.color.get');
    Route::post('/config/color/add', 'ConfigController@addColor')->name('config.color.add');
    Route::post('/config/color/edit', 'ConfigController@editColor')->name('config.color.edit');
    Route::post('/config/color/delete', 'ConfigController@deleteColor')->name('config.color.delete');

    Route::get('/config/size', 'ConfigController@size');
    Route::get('/config/size/get', 'ConfigController@getSize')->name('config.size.get');

    Route::get('/config/gender', 'ConfigController@gender');
    Route::get('/config/gender/get', 'ConfigController@getGender')->name('config.gender.get');
});

Route::get('/login', 'Auth\LoginController@index')->name('auth.login');
Route::post('/login', 'Auth\LoginController@loginProcess')->name('auth.login.process');
Route::post('/logout', 'Auth\LoginController@logOut')->name('auth.logout');
Route::get('/password/reset', 'Auth\ForgotPasswordController@index')->name('password.request');
