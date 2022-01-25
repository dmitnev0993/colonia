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

Route::get('/', [
    'as' => 'home',
    'uses' => 'App\Http\Controllers\HomeController@home'
]);

Route::get('/about-us', [
    'as' => 'about-us',
    'uses' => 'App\Http\Controllers\HomeController@aboutUs'
]);

Route::get('/privacy-policy', [
    'as' => 'privacy-policy',
    'uses' => 'App\Http\Controllers\HomeController@privacyPolicy'
]);

Route::get('/vision-values', [
    'as' => 'vision-values',
    'uses' => 'App\Http\Controllers\HomeController@visionValues'
]);

Route::get('/colonial-strata-terms-and-conditions-sale-special-terms-and-conditions', [
    'as' => 'colonial',
    'uses' => 'App\Http\Controllers\HomeController@colonial'
]);

Route::get('/terms-use', [
    'as' => 'terms-use',
    'uses' => 'App\Http\Controllers\HomeController@terms'
]);

Route::get('/financial-services-guide', [
    'as' => 'financial',
    'uses' => 'App\Http\Controllers\HomeController@financial'
]);

Route::match(['get', 'post'], '/contact-us', [
    'as' => 'contact-us',
    'uses' => 'App\Http\Controllers\HomeController@contactUs'
]);

Route::get('/residential-strata', [
    'as' => 'residential',
    'uses' => 'App\Http\Controllers\HomeController@residential'
]);

Route::get('/commercial-strata', [
    'as' => 'commercial-strata',
    'uses' => 'App\Http\Controllers\HomeController@commercial'
]);

Route::get('/query-residential', [
    'uses' => 'App\Http\Controllers\PageController@queryResidential'
]);

Route::post('/fileupload', [
    'uses' => 'App\Http\Controllers\PageController@fileupload'
]);

Route::post('/search-suburb', [
    'uses' => 'App\Http\Controllers\PageController@searchSuburb'
]);

Route::get('/query-commercial', [
    'uses' => 'App\Http\Controllers\PageController@queryCommercial'
]);
