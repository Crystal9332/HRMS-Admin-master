const mix = require("laravel-mix");

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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.styles(
    [
        "public/icons/font-awesome/css/fontawesome-all.css",
        "public/icons/simple-line-icons/css/simple-line-icons.css",
        "public/icons/weather-icons/css/weather-icons.min.css",
        "public/icons/themify-icons/themify-icons.css",
        "public/icons/icons/flag-icon-css/flag-icon.min.css",
        "public/css/system/morris.css",
        "public/css/system/jquery.toast.css",
        "public/css/system/dashboard1.css",
        "public/css/system/login-register-lock.css",
        "public/icons/material-design-iconic-font/css/materialdesignicons.min.css",
        "public/css/system/dataTables.bootstrap4.css",
        "public/css/system/sweetalert.css",
        "public/css/system/switchery.min.css",
        "public/css/system/daterangepicker.css",
        "public/css/system/dropify.min.css",
        "public/css/system/style.min.css"
    ],
    "public/bundle/css/app.css"
)
    .version()
    .copy("public/css/fonts", "public/bundle/fonts")
    .copy("public/icons/font-awesome/webfonts", "public/bundle/webfonts")
    .copy("public/icons/simple-line-icons/fonts", "public/bundle/fonts")
    .copy("public/icons/weather-icons/fonts", "public/bundle/fonts")
    .copy(
        "public/icons/material-design-iconic-font/fonts",
        "public/bundle/fonts"
    )
    .copy("public/icons/themify-icons/fonts", "public/bundle/css/fonts");

mix.scripts(
    [
        "public/js/system/jquery-3.2.1.min.js",
        "public/js/system/popper.min.js",
        "public/js/system/bootstrap.min.js",
        "public/js/system/perfect-scrollbar.jquery.min.js",
        "public/js/system/waves.js",
        "public/js/system/sidebarmenu.js",
        "public/js/system/sticky-kit.min.js",
        "public/js/system/jquery.sparkline.min.js",
        "public/js/system/datatables.min.js",
        "public/js/system/sweetalert.min.js",
        "public/js/system/switchery.min.js",
        "public/js/system/jquery.toast.js",
        "public/js/system/bootstrap3-typeahead.min.js",
        "public/js/system/custom.min.js",
        "public/js/system/moment.js",
        "public/js/system/dropify.min.js",
        "public/js/system/daterangepicker.js",
        "public/js/system/jquery.PrintArea.js"
    ],
    "public/bundle/js/app.js"
).version();
