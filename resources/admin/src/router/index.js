import Vue from "vue"
import VueRouter from "vue-router"
import backend from "@/components/backend"
Vue.use(VueRouter)
import base from './base'
import cms from './cms'
import sniper from './sniper'
import panel from './panel'
import privileges from './privileges'

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
      children:[
        ...sniper,
        ...privileges,
        ...cms,
        ...base
      ]
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
