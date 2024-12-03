
const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .sass('resources/sass/app.scss', 'public/css') // optional if you use SASS
   .browserSync('localhost:8000'); // change to match your development URL
