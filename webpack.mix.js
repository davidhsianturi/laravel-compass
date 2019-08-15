const mix = require('laravel-mix');
const webpack = require('webpack');
const tailwindcss = require('tailwindcss');

mix
    .options({
        uglify: {
            uglifyOptions: {
                compress: {
                    drop_console: true,
                }
            }
        },
        processCssUrls: false,
    })
    .webpackConfig({
        plugins: [
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
        ],
    })
    .setPublicPath('public')
    .sass('resources/sass/app.scss', 'public', {}, [tailwindcss('./tailwind.js')])
    .version()
    .copy('public', '../compasstest/public/vendor/compass');