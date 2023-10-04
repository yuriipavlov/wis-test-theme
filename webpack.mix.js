/**
 * Laravel mix version 6
 * https://laravel-mix.com/docs
 */
const mix = require('laravel-mix');

/**
 * Connect Glob to resolve paths
 */
const glob = require('glob');

/**
 * https://laravel-mix.com/docs/6.0/api#optionsoptions
 */
mix.options({
  processCssUrls: false
});

/**
 * https://laravel-mix.com/docs/6.0/os-notifications
 */
mix.disableNotifications();

/**
 * https://snyk.io/advisor/npm-package/laravel-mix/functions/laravel-mix.inProduction
 */
if (!mix.inProduction()) {
  mix
    .sourceMaps()
    .webpackConfig({devtool: 'inline-source-map'});
}

//mix.setPublicPath('app/dist');

/**
 * Read the folders and look for assets files
 */
const allAssets = glob.sync('assets/src/**/!(_)*.@(scss|js|jsx)')
  .concat(glob.sync('blocks/**/src/!(_)*.@(scss|js|jsx)'));

allAssets.forEach(assetPath => {

  if (assetPath.endsWith('.scss')) {
    /*const additionalData = assetPath.startsWith('blocks/') ? '' +
      '@import "../../../assets/src/styles/utils/variables";' +
      '@import "../../../assets/src/styles/utils/mixins";' +
      '@import "../../../assets/src/styles/utils/icons";'
      : '';*/
    const additionalData = '';
    mix.sass(assetPath, assetPath.replace(/\/src\//, '/build/').replace(/\.(scss)$/, '.css'), {
      additionalData
    });
  } else if (assetPath.endsWith('.js') || assetPath.endsWith('.jsx')) {
    mix.js(assetPath, assetPath.replace(/\/src\//, '/build/').replace(/\.(jsx)$/, '.js'));
  }
});
