const config = require('flarum-webpack-config');

const webpackConfig = config({});

webpackConfig.entry = {
  admin: './admin.js',
  forum: './forum.js',
};

module.exports = webpackConfig;
