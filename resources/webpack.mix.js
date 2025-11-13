const mix = require('laravel-mix');

/**
 * Build from public_html and write bundles + manifest into public_html/build
 */
mix
  .setPublicPath('public_html')

  // CSS bundle (adjust the list if needed)
  .styles([
    'public_html/css/frontend_css/bootstrap.min.css',
    'public_html/css/frontend_css/font-awesome.min.css',
    'public_html/css/frontend_css/main.css',
    'public_html/css/frontend_css/responsive.css'
  ], 'public_html/build/css/app.css')

  // JS bundle
  .scripts([
    'public_html/js/frontend_js/jquery.js',
    'public_html/js/frontend_js/bootstrap.min.js',
    'public_html/js/frontend_js/main.js'
  ], 'public_html/build/js/app.js')

  .options({
    postCss: [ require('autoprefixer') ],
    processCssUrls: false
  })

  .version()
  .disableNotifications();

mix.webpackConfig({
  performance: { hints: false }
});
