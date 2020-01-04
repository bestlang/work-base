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
    },
    {
      path: "/login",
      component: (resolve) => require(["../pages/login.vue"], resolve),
      meta: {
        name: '登录',
      },
    },
    {
      path: "/dashboard",
      redirect: "/dashboard/home",
      component: backend,
      meta: {
        can: 'dashboard',
        name: '面板'
      },
      children: [
        {
          path: "/dashboard/home",
          component: (resolve) => require(["../pages/dashboard.vue"], resolve),
          meta: {
            can: 'dashboard',
            show: true,
            name: '面板',
            font: '&#xe764;'
          },
        }
      ]
    },
    {
      path: "/activity",
      component: backend,
      meta: {
        can: 'activity',
        name: '活动管理',
        font: '&#xe6c5;'
      },
      children: [
        {
          path: "/activity/list",
          component: (resolve) => require(["../pages/activity/list.vue"], resolve),
          meta: {
            can: 'activity list',
            show: true,
            name: '活动列表',
            font: '&#xe6a3;'
          },
        },
        {
            path: "/activity/add",
            component: (resolve) => require(["../pages/activity/add.vue"], resolve),
            meta: {
              can: 'add activity',
              show: true,
              name: '添加活动',
              font: '&#xe663;'
            },
        },
        {
            path: "/activity/edit",
            component: (resolve) => require(["../pages/activity/edit.vue"], resolve),
            meta: {
              can: 'edit activity',
              show: false,
              name: '编辑活动',
              font: ''
            },
        },
      ]
    },
    {
      path: "/pdd",
      component: backend,
      meta: {
        can: 'pdd',
        name: '拼多多',
        font: '&#xe711;'
      },
      children: [
        {
            path: "/pdd/cat/goods",
            component: (resolve) => require(["../pages/pdd/catGoods.vue"], resolve),
            meta: {
              can: 'pdd cat goods',
              show: true,
              name: '分类商品',
              font: '&#xe711;'
            },
        },
        {
            path: "/pdd/orders",
            component: (resolve) => require(["../pages/pdd/orders.vue"], resolve),
            meta: {
              can: 'pdd orders',
              show: true,
              name: '订单',
              font: '&#xe62f;'
            },
        }
      ]
    },
    {
      path: "/privileges",
      component: backend,
      meta: {
        can: 'privileges',
        name: '权限系统',
        font: '&#xe70b;'
      },
      children: [
        {
            path: "/privileges/roles",
            component: (resolve) => require(["../pages/privileges/roles.vue"], resolve),
            meta: {
              //can: 'privileges roles',
              can: 'privileges list roles',
              show: true,
              name: '角色管理',
              font: '&#xe612;'
            },
        },
        {
          path: "/privileges/permissions",
          component: (resolve) => require(["../pages/privileges/permissions.vue"], resolve),
          meta: {
            //can: 'privileges permissions',
            can: 'privileges list permissions',
            show: true,
            name: '权限管理',
            font: '&#xe70b;'
          },
        },
        {
            path: "/privileges/role/users/:id",
            component: (resolve) => require(["../pages/privileges/role_users.vue"], resolve),
            meta: {
              // can: 'privileges role users',
              can: 'privileges list role users',
              show: false,
              name: '角色用户',
              font: ''
            },
        },
        {
            path: "/privileges/role/permissions/:id/:name",
            component: (resolve) => require(["../pages/privileges/role_permissions.vue"], resolve),
            meta: {
              can: 'privileges role permissions',
              show: false,
              name: '角色权限',
            },
        }
      ]
    }
  ]
})
