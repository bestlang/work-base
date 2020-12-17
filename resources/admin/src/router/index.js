import Vue from "vue"
import VueRouter from "vue-router"
import backend from "@/components/backend"
Vue.use(VueRouter)
import base from './base'
import cms from './cms'
import sniper from './sniper'
import panel from './panel'
import privileges from './privileges'
let pkg = require('../../package')


let children = [];
let allowed = pkg.allowModules;
let allModules = {sniper, panel, cms, base, privileges}
for(let key in allModules){
    if(allModules.hasOwnProperty(key) && allowed.indexOf(key) !== -1){
        children = children.concat(allModules[key])
    }
}

const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
}

export default new VueRouter({
  mode: "hash",// "hash" | "history" | "abstract"
  base: "/",
  saveScrollPosition: "true",
  routes: [
    {
      path: "/",
      component: backend,
      meta: {
        can: '',
        show:false,
        name: '系统菜单',
        font: '&#xe764;'
      },
      children,
    },
      ...panel,
    {
      path: "/login",
      component: () => import("../pages/login.vue"),
      meta: {
        name: '登录',
        show: false
      },
    },
    {
        path: "/test",
        component: () => import("../pages/test.vue"),
        meta: {
            name: 'test',
            show: false
        },
    },
    {
        path:"/no/permission",
        component: () => import("../pages/noPermission.vue"),
        meta: {
            can: "",
            name: 'test',
            show: false
        },
    },
    {
      path: '*',
        component: () => import("../pages/notFound.vue"),
        meta: {
            can: "",
            name: 'wild',
            show: false
        },
    }

  ]
})
