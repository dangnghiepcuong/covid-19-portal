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

mix.autoload({
    jquery: ['$', 'window.jQuery']
});

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/getLocalRegion.js', 'public/js')
    .js('resources/js/getBusinessList.js', 'public/js')
    .postCss('resources/css/custom.css', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .postCss('resources/css/layout.css', 'public/css')
    .postCss('resources/css/size.css', 'public/css')
    .postCss('resources/css/color.css', 'public/css')
    .sass('resources/sass/app.scss', 'public/css');
