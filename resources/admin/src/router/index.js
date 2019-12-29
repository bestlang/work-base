import Vue from "vue"
import VueRouter from "vue-router"
import backend from "@/components/backend"
Vue.use(VueRouter)

export default new VueRouter({
  mode: "history",
  saveScrollPosition: "true",
  routes: [
    {
      path: "/",
      redirect: "/login",
      meta: {
        can: 'newlyadd',
        show: false,
        name: '首页',
      },
    },
    {
      path: "/login",
      component: (resolve) => require(["../pages/login.vue"], resolve),
      meta: {
        show: false,
        name: '登录',
      },
    },
    {
      path: "/dashboard",
      component: backend,
      meta: {
        show: false,
        name: '首页',
        font: '&#xe8f4;'
      },
      children: [
        {
          path: "/dashboard",
          component: (resolve) => require(["../pages/dashboard.vue"], resolve),
          meta: {
            can: 'fuck',
            show: false,
            name: '首页',
            font: '&#xe8f4;'
          },
        }
      ]
    },
    {
      path: "/activity",
      component: backend,
      meta: {
        can: 'newlyadd',
        show: true,
        name: '活动管理',
        font: '&#xe665;'
      },
      children: [
        {
          path: "/activity/list",
          component: (resolve) => require(["../pages/activity/list.vue"], resolve),
          meta: {
            can: 'newlyadd',
            show: true,
            name: '活动列表',
            font: '&#xe954;'
          },
        },
        {
            path: "/activity/add",
            component: (resolve) => require(["../pages/activity/add.vue"], resolve),
            meta: {
              can: 'xxoo',
              show: true,
              name: '活动添加',
              font: '&#xe641;'
            },
        },
        {
            path: "/activity/edit",
            component: (resolve) => require(["../pages/activity/edit.vue"], resolve),
            meta: {
              show: false,
              name: '活动编辑',
            },
        },
      ]
    },
    {
      path: "/pdd",
      component: backend,
      meta: {
        show: true,
        name: '多多管理',
        font: '&#xe614;'
      },
      children: [
        {
            path: "/pdd/cat/goods",
            component: (resolve) => require(["../pages/pdd/catGoods.vue"], resolve),
            meta: {
              can: 'xxoo',
              show: true,
              name: '分类商品',
              font: '&#xe684;'
            },
        },
        {
            path: "/pdd/orders",
            component: (resolve) => require(["../pages/pdd/orders.vue"], resolve),
            meta: {
              can: 'newlyadd',
              show: true,
              name: '购买订单',
              font: '&#xe84b;'
            },
        }
      ]
    },
    {
      path: "/privileges",
      component: backend,
      meta: {
        show: true,
        name: '权限管理',
        font: '&#xe60d;'
      },
      children: [
        {
            path: "/privileges/roles",
            component: (resolve) => require(["../pages/privileges/roles.vue"], resolve),
            meta: {
              can: 'newlyadd',
              show: true,
              name: '角色管理',
              font: '&#xe954;'
            },
        },
        {
          path: "/privileges/permissions",
          component: (resolve) => require(["../pages/privileges/permissions.vue"], resolve),
          meta: {
            can: 'newlyadd',
            show: true,
            name: '权限管理',
            font: '&#xe954;'
          },
        },
        {
            path: "/privileges/role/users/:id",
            component: (resolve) => require(["../pages/privileges/role_users.vue"], resolve),
            meta: {
              show: false,
              name: '角色用户',
            },
        },
        {
            path: "/privileges/role/permissions/:id/:name",
            component: (resolve) => require(["../pages/privileges/role_permissions.vue"], resolve),
            meta: {
              show: false,
              name: '角色权限',
            },
        }
      ]
    }
  ]
})
