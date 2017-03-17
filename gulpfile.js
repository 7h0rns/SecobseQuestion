const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
        .sass('layout/nav.scss', 'public/css/other')
        .sass('other_pages/main.scss', 'public/css/other')
        .sass('other_pages/home.scss', 'public/css/other')
        .sass('other_pages/profile.scss', 'public/css/other')
        .sass('other_pages/show.scss', 'public/css/other')
        .sass('other_pages/questions.scss', 'public/css/other')
        .sass('other_pages/posts.scss', 'public/css/other')
        .copy('node_modules/font-awesome/fonts', 'public/fonts')
        .copy('node_modules/simplemde/dist/simplemde.min.css', 'public/css/simplemde.min.css')
        .copy('node_modules/simplemde/dist/simplemde.min.js', 'public/js/simplemde.min.js')
        .copy('node_modules/select2/dist/js/select2.min.js', 'public/js/select2.min.js')
        .copy('node_modules/select2/dist/css/select2.min.css', 'public/css/select2.min.css')
        .copy('resources/assets/sass/share.min.css', 'public/css/share.min.css')
        .copy('node_modules/social-share.js/dist/js/social-share.min.js', 'public/js/social-share.min.js')
        .copy('node_modules/social-share.js/dist/fonts', 'public/fonts')
        .copy('resources/assets/js/home.js','public/js/home.js')
        .copy('node_modules/select2-bootstrap-theme/dist/select2-bootstrap.min.css', 'public/css/select2-bootstrap.min.css')
        .webpack('app.js');
})
;
