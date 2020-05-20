import Vue from "vue"
import ElementUI from "element-ui"
import "./css/ele-default-theme/theme/index.css"
import "@/css/index.scss"
import router from "./router"
import store from "./store"
import * as types from "./store/types"
import App from "./App"
import {fetch} from "@/api/fetch"
import {getPrefix} from "@/api/util"

window.$ = require("jquery")


Vue.config.productionTip = false

Vue.use(ElementUI)

Vue.prototype.fetch = fetch
Vue.prototype.$types = types
Vue.prototype.SITE_URL = process.env.SITE_URL
Vue.prototype.ADMIN_URL = process.env.ADMIN_URL


Vue.directive('title', {
    inserted: function (el, binding) {
        document.title = binding.value
        el.remove()
    }
})
console.log(`::::::::::`,getPrefix())

export default new Vue({
  el: "#app",
  router,
  store,
  components: { App },
  template: "<App/>"
})

