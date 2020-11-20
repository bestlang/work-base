import "babel-polyfill"
import Vue from "vue"
import ElementUI from "element-ui"

import "element-ui/lib/theme-chalk/index.css"
import "@/css/index.scss"
import router from "./router"
import store from "./store"
import types from "sysStore/types"
import App from "./App"
import {fetch} from "@/api/fetch"
import {getPrefix} from "@/api/util"
import "./control"

window.$  = require("jquery")


Vue.config.productionTip = false

Vue.use(ElementUI)

Vue.prototype.fetch = fetch
Vue.prototype.$types = types
Vue.prototype.SITE_URL = process.env.SITE_URL;//在config/dev.env中被覆盖
Vue.prototype.ADMIN_URL = process.env.ADMIN_URL
// const originalInfo = Vue.prototype.$message.info
// Vue.prototype.$message.info = function info(info) {
//     Vue.prototype.$message.closeAll()
//     return originalInfo.apply(this, [info])
// }
// Vue.prototype.showMessage = (value, type='error') => { // type in [success, warning, info, error]
//     /*手动关闭所有实例*/
//     ElementUI.Message.closeAll()
//     return ElementUI.Message({
//         showClose: true,
//         message: value,
//         type: type,
//         duration: 3500
//     });
// }


Vue.directive('title', {
    inserted: function (el, binding) {
        document.title = binding.value
        try{
            el.remove()
        }catch (e) {
            el.removeNode(true)//ie
        }
    }
})

export default new Vue({
  el: "#app",
  router,
  store,
  components: { App },
  template: "<App/>"
})

/*
import Echo from 'laravel-echo'

window.io = require('socket.io-client');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

window.Echo.channel('user1')
    .listen('ExampleEvent', function(e) {
        ElementUI.Notification({
            title: '您有一条消息',
            message: e.data,
            position: 'bottom-right',
            showClose: true,
            duration: 0
        })
    });
*/
