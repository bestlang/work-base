const mix = require('laravel-mix');
const basePath = 'bestlang/base/resources/assets'
const laraCMSPath = 'bestlang/laracms/resources/assets'
const sniperPath = 'sniper/employee/resources/assets'

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

// mix.js('resources/js/app.js', 'public/vendor/laracms/dark/')
//     .sass('resources/sass/front.scss', 'public/vendor/laracms/dark/');

// mix.less('resources/less/cms.less', 'public/css');

//mix.js(basePath + '/js/app.js', 'public/vendor/base/')
//
//mix.js(laraCMSPath + '/dark/js/app.js', 'public/vendor/laracms/dark/')
    //.sass(laraCMSPath + '/dark/sass/front.scss', 'public/vendor/laracms/dark/front.css')
    //.copy(laraCMSPath + '/dark/images', 'public/')

mix.less(laraCMSPath + '/dark/less/front.less', 'public/vendor/laracms/dark/front.css')
    .copy('public/vendor/laracms/dark/front.css', laraCMSPath+'/dark/front.css')

// mix.less(sniperPath + '/dark/less/front.less', 'public/vendor/laracms/dark/front.css')
//     .copy('public/vendor/laracms/dark/front.css', laraCMSPath+'/dark/front.css')

//mix.js(sniperPath + '/js/app.js', 'public/vendor/sniper/')
    //.copy(sniperPath + '/images', 'public/vendor/sniper/images/')


