const config = require('laravel-mix/setup/webpack.config');

// Exclude SVG from laravel-mix webpack config, we will handle them svgo-loader
// See also: https://github.com/JeffreyWay/laravel-mix/issues/350
for (const rule of config.module.rules) {
    if (rule.test.toString() === '/(\\.(png|jpe?g|gif)$|^((?!font).)*\\.svg$)/') {
        rule.test = /(\.(png|jpe?g|gif)$|^((?!font).)$)/;
    }
}

module.exports = config;
