// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.


import Vue from "vue"
import ElementUI from "element-ui"
// import "element-ui/lib/theme-chalk/index.css"
import "./css/ele-default-theme/theme/index.css"
import "@/css/index.scss"
import Vuex from "vuex"
import router from "./router"
import store from "./store"
import * as types from "./store/types"
import App from "./App"
import fetch from "@/api/fetch"
import "./permissions"

import Utils from "@/utils/global"


window.$ = require("jquery")


Vue.config.productionTip = false

Vue.use(ElementUI)
Vue.use(Vuex)
Vue.use(Utils)
Vue.prototype.$http = fetch
Vue.prototype.$types = types
Vue.prototype.SITE_URL = process.env.SITE_URL
Vue.prototype.ADMIN_URL = process.env.ADMIN_URL

export default new Vue({
  el: "#app",
  router,
  store,
  components: { App },
  template: "<App/>"
})

