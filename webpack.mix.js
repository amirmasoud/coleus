const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.js('resources/assets/js/admin.js', 'public/admin/js')
    .js('resources/assets/js/admin/author.js', 'public/admin/js')
    .js('resources/assets/js/admin/book.js', 'public/admin/js')
    .js('resources/assets/js/admin/json-editor.js', 'public/admin/js')
    .sass('resources/assets/sass/admin.scss', 'public/admin/css');

if (mix.config.inProduction) {
    mix.version();
}