const mix = require('laravel-mix')

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
//base
mix.js('./vendor/base/js/app.js', 'dist/base/')
//
mix.js('./vendor/laracms/dark/js/app.js', 'dist/laracms/dark/')
    .sass('./vendor/laracms/dark/sass/front.scss', 'dist/laracms/dark/')

