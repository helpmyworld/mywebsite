const mix = require('laravel-mix');

/**
 * Bundle your existing public assets into one CSS and one JS,
 * version them (cache-bust), and write to public/build/.
 */
mix
  .styles([
    'public/css/frontend_css/bootstrap.min.css',
    'public/css/frontend_css/font-awesome.min.css',
    'public/css/frontend_css/main.css',
    'public/css/frontend_css/responsive.css'
  ], 'public/build/css/app.css')

  .scripts([
    'public/js/frontend_js/jquery.js',
    'public/js/frontend_js/bootstrap.min.js',
    'public/js/frontend_js/main.js'
  ], 'public/build/js/app.js')

  .options({
    postCss: [ require('autoprefixer') ],
    processCssUrls: false
  })

  .version()
  .disableNotifications();

mix.webpackConfig({
  performance: { hints: false }
});
