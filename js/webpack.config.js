const config = require('flarum-webpack-config');

const webpackConfig = config({});

webpackConfig.entry = {
  admin: './admin.ts',
  forum: './forum.ts',
};

module.exports = webpackConfig;
