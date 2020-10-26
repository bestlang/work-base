'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
    NODE_ENV: '"development"',
    SITE_URL: '"http://127.0.0.1:8080"',

    SERVER_URL: 'http://127.0.0.1:8000',
    //SERVER_URL: '"http://www.laracms.com"',
})
