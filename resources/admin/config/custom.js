'use strict';
module.exports = {
    //SITE_URL: "https://www.larashop.com"
    SITE_URL: process.env.NODE_ENV === 'development' ? "http://127.0.0.1:8000":"",
    ADMIN_URI: "/admin"
}
