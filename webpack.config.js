const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '@lang': path.resolve('./resources/lang'),
        },
    },
    module: {
        rules: [
            {
                test: /resources[\\\/]lang.+\.(php)$/,
                loader: 'php-array-loader',
            },
        ],
    },
};
