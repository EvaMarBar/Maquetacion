<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\LoginController;
use App\Vendor\Locale\LocalizationSeo;

$localizationseo = new LocalizationSeo();
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

Route::post('/fingerprint', 'App\Http\Controllers\Front\FingerprintController@store')->name('front_fingerprint');
Route::get('/login', 'App\Http\Controllers\Front\LoginController@index')->name('front_login');
Route::post('/login', 'App\Http\Controllers\Front\LoginController@login')->name('front_login_submit');
Route::get('/', 'App\Http\Controllers\Front\HomeController@index')->name('home_front');

Route::get('/faqs', 'App\Http\Controllers\Front\FaqController@index')->name('faqs_front');

Route::group(['prefix' => $localizationseo->setLocale(),
              'middleware' => [ 'localize' ]
            ], function () use ($localizationseo) {

    Route::get($localizationseo->transRoute('routes.front_faqs'), 'App\Http\Controllers\Front\FaqController@index')->name('front_faqs');
    Route::get($localizationseo->transRoute('routes.front_faq'), 'App\Http\Controllers\Front\FaqController@show')->name('front_faq');

    Route::get($localizationseo->transRoute('routes.front_products'), 'App\Http\Controllers\Front\ShirtController@index')->name('front_products');
    Route::get($localizationseo->transRoute('routes.front_product'), 'App\Http\Controllers\Front\ShirtController@show')->name('front_product');
});

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

    Route::get('/faqs/filter/{filters?}', 'App\Http\Controllers\Admin\FaqController@filter')->name('faqs_filter');
    Route::resource('faqs', 'App\Http\Controllers\Admin\FaqController', [
        'names' => [
            'index' => 'faqs',
            'create' => 'faqs_create',
            'store' => 'faqs_store',
            'destroy' => 'faqs_destroy',
            'show' => 'faqs_show',
        ]
    ]);
    Route::resource('usuarios', 'App\Http\Controllers\Admin\UserController', [
        'parameters' => [
            'usuarios' => 'user', 
        ],
        'names' => [
            'index' => 'users',
            'create' => 'users_create',
            'store' => 'users_store',
            'destroy' => 'users_destroy',
            'show' => 'users_show',
        ]
    ]);

    Route::resource('clientes', 'App\Http\Controllers\Admin\ClientController', [
        'parameters' => [
            'clientes' => 'client', 
        ],
        'names' => [
            'index' => 'clients',
            'create' => 'clients_create',
            'store' => 'clients_store',
            'destroy' => 'clients_destroy',
            'show' => 'clients_show',
        ]
    ]);

    Route::get('/sliders/filter/{filters?}', 'App\Http\Controllers\Admin\SliderController@filter')->name('sliders_filter');
    Route::resource('sliders', 'App\Http\Controllers\Admin\SliderController', [
        'names' => [
            'index' => 'sliders',
            'create' => 'sliders_create',
            'store' => 'sliders_store',
            'destroy' => 'sliders_destroy',
            'show' => 'sliders_show',
        ]
    ]);

    // Route::get('/sliders/filter/{filters?}', 'App\Http\Controllers\Admin\SliderController@filter')->name('sliders_filter');
    Route::resource('camisetas', 'App\Http\Controllers\Products\ShirtController', [
        'parameters' => [
            'camisetas' => 'shirt', 
        ],
        'names' => [
            'index' => 'shirts',
            'create' => 'shirts_create',
            'store' => 'shirts_store',
            'destroy' => 'shirts_destroy',
            'show' => 'shirts_show',
        ]
    ]);
    Route::post('/specifications', 'App\Http\Controllers\Products\SpecificationController@store')->name('specification_store');

    Route::post('/sizes', 'App\Http\Controllers\Products\SizeController@store')->name('size_store');
    Route::post('/colours', 'App\Http\Controllers\Products\ColourController@store')->name('colour_store');



    Route::get('/seo/sitemap', 'App\Http\Controllers\Admin\LocaleSeoController@getSitemaps')->name('create_sitemap');
    Route::get('/seo/import', 'App\Http\Controllers\Admin\LocaleSeoController@importSeo')->name('seo_import');
    Route::get('/seo/{key}', 'App\Http\Controllers\Admin\LocaleSeoController@edit')->name('seo_edit');
    Route::get('/seo', 'App\Http\Controllers\Admin\LocaleSeoController@index')->name('seo');
    Route::post('/seo', 'App\Http\Controllers\Admin\LocaleSeoController@store')->name('seo_store');
    Route::get('/ping-google', 'App\Http\Controllers\Admin\LocaleSeoController@pingGoogle')->name('ping_google');

    Route::get('/tags/{group}/{key}', 'App\Http\Controllers\Admin\LocaleTagController@show')->name('taqs_show');
    Route::get('/tags', 'App\Http\Controllers\Admin\LocaleTagController@index')->name('tags');
    Route::post('/tags', 'App\Http\Controllers\Admin\LocaleTagController@store')->name('tags_store');
    Route::get('/tags/import', 'App\Http\Controllers\Admin\LocaleTagController@importTags')->name('tags_import');
    Route::get('/tags/filter/{filters?}', 'App\Http\Controllers\Admin\LocaleTagController@filter')->name('tags_filter');

    
    Route::get('/image/delete/{image?}', 'App\Vendor\Image\Image@destroy')->name('delete_image');
    Route::get('/image/temporal/{image?}', 'App\Vendor\Image\Image@showTemporal')->name('show_temporal_image_seo');
    Route::get('/image/{image}', 'App\Vendor\Image\Image@show')->name('show_image_seo');
    Route::post('/image/seo', 'App\Vendor\Image\Image@storeSeo')->name('store_image_seo');
});

