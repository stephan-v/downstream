const mix = require('laravel-mix');
const svgo = require('./resources/assets/config/svgo.plugins.json');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .disableNotifications();

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps(true, 'cheap-module-inline-source-map');
}

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.svg$/,
                use: [
                    {
                        loader: 'raw-loader',
                        query: {
                            name: 'resources/assets/svg/[name].[ext]'
                        }
                    },
                    {
                        loader: 'svgo-loader',
                        options: svgo
                    }
                ]
            }
        ]
    },
    resolve: {
        modules: [
            path.resolve('./'),
            path.resolve('./node_modules')
        ],
        alias: {
            '@': 'resources/assets/js'
        }
    }
});
