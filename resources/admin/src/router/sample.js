import Vue from "vue"
import VueRouter from "vue-router"
import backend from "@/components/backend"
Vue.use(VueRouter)

export default new VueRouter({
  mode: "history",
  saveScrollPosition: "true",
  routes: [
    {
      path: '/',
      redirect: '/login',
      meta: {
        menuShow: false
      }
    },
    {
      path: '/login',
      name: 'login',
      component: (resolve) => require(["../pages/dashboard.vue"], resolve),
      meta: {
        menuShow: false,
      }
    },

    {
      path: '/system',
      name: 'system',
      component: (resolve) => require(["../pages/dashboard.vue"], resolve),
      meta: {
        menuShow: true,          // 是否在导航栏中显示
        menuName: '系统管理',     // 导航栏中显示的名称
      },
      children: [
        {
          path: '/system/organization',
          name: 'organization',
          component: (resolve) => require(["../pages/dashboard.vue"], resolve),
          meta: {
            menuShow: true,
            menuName: '组织架构',
          }
        },
        {
          path: '/system/userManage',
          name: 'userManage',
          component: (resolve) => require(["../pages/dashboard.vue"], resolve),
          meta: {
            menuShow: true,
            menuName: '用户管理',
          }
        },
        {
          path: '/system/systemSet',
          name: 'systemSet',
          component: (resolve) => require(["../pages/dashboard.vue"], resolve),
          meta: {
            menuShow: true,
            menuName: '系统设置',
          }
        },
        {
          path: '/system/operationLog',
          name: 'operationLog',
          component: (resolve) => require(["../pages/dashboard.vue"], resolve),
          meta: {
            menuShow: true,
            menuName: '操作日志',
          }
        },
      ]
    },
  ]
})
