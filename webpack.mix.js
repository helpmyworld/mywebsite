const mix = require('laravel-mix');

/**
 * App root: /home/helpmyworld/helpmyworld
 * Web root: /home/helpmyworld/public_html   (sibling of app root)
 *
 * Use sibling paths with "../public_html".
 */

mix
  // All outputs go to public_html
  .setPublicPath('../public_html')

  // ===== CSS bundle =====
  .styles([
    '../public_html/css/frontend_css/bootstrap.min.css',
    '../public_html/css/frontend_css/font-awesome.min.css',
    '../public_html/css/frontend_css/main.css',
    '../public_html/css/frontend_css/responsive.css',
  ], '../public_html/build/css/app.css')

  // ===== JS bundle =====
  .scripts([
    '../public_html/js/frontend_js/jquery.js',
    '../public_html/js/frontend_js/bootstrap.min.js',
    '../public_html/js/frontend_js/main.js',
  ], '../public_html/build/js/app.js')

  .options({
    postCss: [ require('autoprefixer') ],
    processCssUrls: false,
  })

  // Cache-busting + quieter output
  .version()
  .disableNotifications();

mix.webpackConfig({
  performance: { hints: false },
});
