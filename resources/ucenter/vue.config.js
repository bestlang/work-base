const path = require('path');

module.exports = {
    outputDir: path.resolve(__dirname, '../../public/ucenter/'),
    publicPath: process.env.NODE_ENV === 'production' ? '/ucenter/' : '/',
    devServer: {
        proxy: 'http://127.0.0.1:8000'
    }
}