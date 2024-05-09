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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/getLocalRegion.js', 'public/js')
    .js('resources/js/translate.js', 'public/js')
    .js('resources/js/getBusinessList.js', 'public/js')
    .js('resources/js/getScheduleList.js', 'public/js')
    .js('resources/js/registerVaccination.js', 'public/js')
    .js('resources/js/notification.js', 'public/js')
    .js('resources/js/dashboard.js', 'public/js')
    .js('resources/js/chart-bar.js', 'public/js')
    .js('resources/js/chart-line.js', 'public/js')
    .js('node_modules/toastr/build/toastr.min.js', 'public/js')
    .js('node_modules/pusher-js/dist/web/pusher.min.js', 'public/js')
    .js('node_modules/pusher-js/dist/web/pusher.js', 'public/js')
mix.postCss('resources/css/custom.css', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .postCss('resources/css/layout.css', 'public/css')
    .postCss('resources/css/size.css', 'public/css')
    .postCss('resources/css/color.css', 'public/css')
    .postCss('resources/css/notification.css', 'public/css')
    .postCss('node_modules/toastr/build/toastr.min.css', 'public/css')
    .sass('resources/sass/app.scss', 'public/css');
