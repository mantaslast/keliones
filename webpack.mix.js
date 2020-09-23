const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.copyDirectory('resources/assets/fonts', 'public/fonts');

mix.js('resources/js/app.js', 'public/js').version()
    .sass('resources/sass/app.scss', 'public/css').version()
    .js('resources/js/blade/common.js', 'public/js/common')
    .js('resources/js/blade/admin.js', 'public/js/admin');