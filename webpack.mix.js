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

// TODO: Compile dashboard.js and pass it to templates.

mix.react('resources/js/app.js', 'public/js/app.js')
   .react('resources/js/dashboard.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
