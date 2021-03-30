const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.js('resources/js/admin/desktop/app.js', 'public/admin/desktop/js').version()
    .js('resources/js/admin/mobile/app.js', 'public/admin/mobile/js').version()
    .js('resources/js/front/desktop/app.js', 'public/front/desktop/js').version()
    .js('resources/js/front/mobile/app.js', 'public/front/mobile/js').version()
    .sass('resources/sass/admin/desktop/app.scss', 'public/admin/desktop/css')
    .sass('resources/sass/admin/mobile/app.scss', 'public/admin/mobile/css')
    .sass('resources/sass/front/desktop/app.scss', 'public/front/desktop/css')
    .sass('resources/sass/front/mobile/app.scss', 'public/front/mobile/css');