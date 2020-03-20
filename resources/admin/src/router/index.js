import Vue from "vue"
import VueRouter from "vue-router"
import backend from "@/components/backend"
Vue.use(VueRouter)

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
              }
            },
            {
              path: "/cms/position",
              component: (resolve) => require(["../components/via.vue"], resolve),
                meta: {
                    can: 'cms list contents',
                    show: true,
                    name: '推荐管理',
                    font: '&#xe764;'
                },
                children:[
                    {
                        path: "/cms/position/position",
                        component: (resolve) => require(["../pages/cms/position/position.vue"], resolve),
                        meta: {
                            can: 'dashboard',
                            show: true,
                            name: '推荐位',
                            font: '&#xe764;'
                        },
                    },
                    {
                        path: "/cms/position/content",
                        component: (resolve) => require(["../pages/cms/position/content.vue"], resolve),
                        meta: {
                            can: 'dashboard',
                            show: false,
                            name: '内容管理',
                            font: '&#xe764;'
                        },
                    },
                    {
                        path: "/cms/position/subs",
                        component: (resolve) => require(["../pages/cms/position/subs.vue"], resolve),
                        meta: {
                            can: 'dashboard',
                            show: false,
                            name: '内容推荐位',
                            font: '&#xe764;'
                        },
                    }
                ]
            },
            {
              path: "/cms/comment",
              component: (resolve) => require(["../pages/cms/comment.vue"], resolve),
              meta: {
                  can: 'cms list contents',
                  show: true,
                  name: '评论管理',
                  font: '&#xe764;'
              }
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
                  component: (resolve) => require(["../pages/cms/setting/modelEdit.vue"], resolve),
                  meta: {
                    can: 'dashboard',
                    show: false,
                    name: '添加模型',
                    font: '&#xe764;'
                  }
                },
                {
                  path: "/cms/setting/model/edit",
                  component: (resolve) => require(["../pages/cms/setting/modelEdit.vue"], resolve),
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
              path: "/privileges/roles/users",
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
              path: "/privileges/roles/permissions",
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
