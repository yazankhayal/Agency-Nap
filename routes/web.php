<?php

Route::get('/admin/login', 'Auth\LoginAdminController@login_admin')->name('login_admin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomepageController@index')->name('index');

Route::get('/services', 'HomepageController@services')->name('services');
Route::get('/portfolio', 'HomepageController@portfolio')->name('portfolio');
Route::get('/about', 'HomepageController@about')->name('about');
Route::get('/products', 'HomepageController@products')->name('products');
Route::post('/request_services_post', 'HomepageController@request_products_post')->name('request_products_post');

Route::get('/contact', 'HomepageController@contact_us')->name('contact');
Route::post('/contact_post', 'HomepageController@contact_post')->name('contact_post');
Route::post('/request_product', 'HomepageController@request_product')->name('request_product');
Route::get('/blog', 'HomepageController@blog')->name('blog');

Route::get('/gallery', 'HomepageController@gallery')->name('gallery');
Route::get('/product/{id?}/{name?}', 'HomepageController@product')->name('product');

Route::post('/newsletter', 'HomepageController@newsletter')->name('newsletter');
Route::get('/change_language/{lang?}', 'HomepageController@change_language')->name('change_language');
Route::get('/currency_change/{id?}', 'HomepageController@currency_change')->name('currency_change');
Route::get('/blog/{id?}/{name?}', 'HomepageController@post')->name('post');
Route::get('/service/{id?}/{name?}', 'HomepageController@service')->name('service');
