const config = require('flarum-webpack-config');

const webpackConfig = config({});

webpackConfig.entry = {
  admin: './admin.js',
};

module.exports = webpackConfig;
