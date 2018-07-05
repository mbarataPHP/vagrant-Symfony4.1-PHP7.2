'use strict'
const Dotenv = require('dotenv-webpack');
const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');



module.exports = {
    mode: 'development',
    entry: './assets/main.js',
    output: {
        path: path.resolve(__dirname, 'public'),
        filename: 'bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                use: 'vue-loader'
            },
            {
                test: /\.css$/,
                use: [
                    'style-loader',
                    'css-loader'
                ]
            }
       ]
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' pour webpack 1
        }
    },
    plugins: [
        new VueLoaderPlugin(),
        new Dotenv()
    ]
};