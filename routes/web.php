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
    Route::get($localizationseo->transRoute('routes.front_product_filter'), 'App\Http\Controllers\Front\ShirtController@filter')->name('shirts_filter');
    Route::get($localizationseo->transRoute('routes.front_contact'), 'App\Http\Controllers\Front\ContactController@index')->name('front_contact');
    Route::get($localizationseo->transRoute('routes.front_about_us'), 'App\Http\Controllers\Front\AboutUsController@index')->name('front_about_us');
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

    Route::get('/menus/item/index/{language?}/{item?}', 'App\Http\Controllers\Admin\MenuItemController@index')->name('menus_item_index');
    Route::get('/menus/item/create/{language?}', 'App\Http\Controllers\Admin\MenuItemController@create')->name('menus_item_create');
    Route::delete('/menus/item/delete/{item?}', 'App\Http\Controllers\Admin\MenuItemController@destroy')->name('menus_item_destroy');
    Route::get('/menus/item/edit/{item?}', 'App\Http\Controllers\Admin\MenuItemController@edit')->name('menus_item_edit');
    Route::post('/menus/item/store', 'App\Http\Controllers\Admin\MenuItemController@store')->name('menus_item_store'); 
    Route::post('/menus/item/reordermenu', 'App\Http\Controllers\Admin\MenuItemController@orderItem')->name('menus_reorder');
    
    Route::resource('menus', 'App\Http\Controllers\Admin\MenuController', [
        'names' => [
            'index' => 'menus',
            'create' => 'menus_create',
            'store' => 'menus_store',
            'destroy' => 'menus_destroy',
            'edit' => 'menus_edit',
        ]
    ]);
    Route::get('/informacion-de-la-empresa', 'App\Http\Controllers\Admin\BusinessInformationController@index')->name('business_information');
    Route::post('/informacion-de-la-empresa', 'App\Http\Controllers\Admin\BusinessInformationController@store')->name('business_information_store');
    Route::post('/contacto', 'App\Http\Controllers\Front\ContactController@store')->name('front_contact_form');
    Route::get('/traduccion/{language}/{parent}/{slug?}', 'App\Http\Controllers\Front\LocalizationController@show')->name('front_localization');
});

