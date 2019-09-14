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

//mix.js('resources/js/app.js', 'public/js/bootstrap.js')
//    .sass('resources/sass/app.scss', 'public/css/bootstrap.css');

//mix.styles(['node_modules/bootstrap-rtl/dist/css/bootstrap-rtl.css'], 'public/css/bootstrap-rtl.css');

//mix.sass('resources/sass/font-awesome.scss', 'public/css/font-awesome.css');

//mix.js('resources/js/app.js', 'public/js/bootstrap-select.js')

mix.js('node_modules/bootstrap-select/js/bootstrap-select.js','public/js/bootstrap-select.js');

//mix.js('node_modules/bootstrap-select/js/i18n/defaults-fa_IR.js','public/js/defaults-fa_IR.js');