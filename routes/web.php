<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqCategoryController;
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

//Route::get('/faqs', 'App\Http\Controllers\Front\FaqController@index');[UserController::class
Route::get('/faqs', 'App\Http\Controllers\Front\FaqController@index',[
    'names' => [
        'index' => 'faqs',
    ]]);

Route::group(['prefix' => 'admin'],function (){

    Route::resource('faqs/categorias', 'App\Http\Controllers\Admin\FaqCategoryController', [
        'parameters' => [
            'categorias' => 'faq_category', 
        ],
        'names' => [
            'index' => 'faqs_category',
            'create' => 'faqs_category_create',
            'store' => 'faqs_category_store',
            'destroy' => 'faqs_category_destroy',
            'show' => 'faqs_category_show',
        ]
    ]);

    //Route::get('/faqs/json', 'App\Http\Controllers\Admin\FaqController@indexJson')->name('faqs_json');
    Route::resource('faqs', 'App\Http\Controllers\Admin\FaqController', [
        'names' => [
            'index' => 'faqs',
            'create' => 'faqs_create',
            'store' => 'faqs_store',
            'destroy' => 'faqs_destroy',
            'show' => 'faqs_show',
        ]
    ]);
   
});

