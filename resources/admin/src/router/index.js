import Vue from "vue"
import VueRouter from "vue-router"
import backend from "@/components/backend"
Vue.use(VueRouter)

export default new VueRouter({
  mode: "history",// "hash" | "history" | "abstract"
  base: "/admin/",
  saveScrollPosition: "true",
  routes: [
    {
      path: "/",
      component: backend,
      meta: {
        can: '',
        show:false,
        name: '根菜单'
      },
      children:[
        {
          path: "/dashboard",
          component:  (resolve) => require(["../pages/dashboard.vue"], resolve),
          meta: {
            can: 'dashboard',
            show:true,
            name: '面板',
            font: '&#xe764;'
          }
        },
        {
          path: "/cms",
          component: (resolve) => require(["../components/via.vue"], resolve),
          meta: {
            can: 'cms',
            show:true,
            name: '内容管理',
            font: '&#xe764;'
          },
          children: [
            {
              path: "/cms/content",
              component: (resolve) => require(["../pages/cms/content.vue"], resolve),
              meta: {
                can: 'cms list contents',
                show: true,
                name: '内容管理',
                font: '&#xe764;'
              },
            },
            {
              path: "/cms/channel",
              component: (resolve) => require(["../pages/cms/channel.vue"], resolve),
              meta: {
                can: 'cms list channels',
                show: true,
                name: '栏目管理',
                font: '&#xe764;'
              },
            },
            {
              path: "/cms/setting",
              component: (resolve) => require(["../components/via.vue"], resolve),
              meta: {
                can: 'cms list contents',
                show: true,
                name: '设置',
                font: '&#xe764;'
              },
              children: [
                {
                  path: "/cms/setting/model",
                  component: (resolve) => require(["../pages/cms/setting/model.vue"], resolve),
                  meta: {
                    can: 'dashboard',
                    show: true,
                    name: '模型管理',
                    font: '&#xe764;'
                  },
                },
                {
                  path: "/cms/setting/model/add",
                  component: (resolve) => require(["../pages/cms/setting/modelAdd.vue"], resolve),
                  meta: {
                    can: 'dashboard',
                    show: false,
                    name: '添加模型',
                    font: '&#xe764;'
                  }
                },
                {
                  path: "/cms/setting/model/edit/:id",
                  component: (resolve) => require(["../pages/cms/setting/modelAdd.vue"], resolve),
                  meta: {
                    can: 'dashboard',
                    show: false,
                    name: '编辑模型',
                    font: '&#xe764;'
                  }
                },
                {
                  path: "/cms/setting/field/types",
                  component: (resolve) => require(["../pages/cms/setting/fieldTypes.vue"], resolve),
                  meta: {
                    can: 'dashboard',
                    show: true,
                    name: '字段类型',
                    font: '&#xe764;'
                  }
                }
              ]
            }
          ]
        },
        {
          path: "/activity",
          component: (resolve) => require(["../components/via.vue"], resolve),
          meta: {
            can: 'activity',
            show: true,
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
              }
            },
            {
              path: "/activity/edit",
              component: (resolve) => require(["../pages/activity/edit.vue"], resolve),
              meta: {
                can: 'edit activity',
                show: false,
                name: '编辑活动',
                font: ''
              }
            },
          ]
        },
        {
          path: "/pdd",
          component: (resolve) => require(["../components/via.vue"], resolve),
          meta: {
            can: 'pdd',
            name: '拼多多',
            font: '&#xe711;'
          },
          children: [
            {
              path: "/pdd/cat",
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
          component: (resolve) => require(["../components/via.vue"], resolve),
          meta: {
            can: 'privileges',
            show: true,
            name: '权限系统',
            font: '&#xe70b;'
          },
          children: [
            {
              path: "/privileges/roles",
              component: (resolve) => require(["../pages/privileges/roles.vue"], resolve),
              meta: {
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
                can: 'privileges list permissions',
                show: true,
                name: '权限管理',
                font: '&#xe70b;'
              },
            },
            {
              path: "/privileges/roles/users/:id",
              component: (resolve) => require(["../pages/privileges/roleUsers.vue"], resolve),
              meta: {
                // can: 'privileges role users',
                can: 'privileges list role users',
                show: false,
                name: '角色用户',
                font: ''
              },
            },
            {
              path: "/privileges/roles/permissions/:id",
              component: (resolve) => require(["../pages/privileges/rolePermissions.vue"], resolve),
              meta: {
                can: 'privileges role permissions',
                show: false,
                name: '角色权限',
                font: ''
              },
            }
          ]
        }
      ]
    },
    {
      path: "/login",
      component: (resolve) => require(["../pages/login.vue"], resolve),
      meta: {
        name: '登录',
      },
    }

  ]
})
