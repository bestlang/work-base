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
          component:  () => import("../pages/dashboard.vue"),
          meta: {
            can: 'dashboard',
            show:true,
            name: '面板',
            font: '&#xe764;'
          }
        },
        {
              path: "/sniper/employee",
              component: () => import("../components/via.vue"),
              meta: {
                  can: 'cms',
                  show: true,
                  name: '人力资源',
                  font: '&#xe612;'
              },
              children: [
                  {
                      path: "/basic/department",
                      component: () => import("../pages/sniper/employee/basic/department.vue"),
                      meta: {
                          can: 'cms',
                          show: true,
                          name: '部门管理',
                          font: '&#xe69a;'
                      }
                  },
                  {
                      path: "/basic/department/edit",
                      component: () => import("../pages/sniper/employee/basic/departmentEdit.vue"),
                      meta: {
                          can: 'cms',
                          show: false,
                          name: '新增部门',
                          font: '&#xe612;'
                      }
                  },
                  {
                      path: "/basic/department/detail",
                      component: () => import("../pages/sniper/employee/basic/departmentDetail.vue"),
                      meta: {
                          can: 'cms',
                          show: false,
                          name: '部门详情',
                          font: '&#xe612;'
                      }
                  },
                  {
                      path: "/basic/position",
                      component: () => import("../pages/sniper/employee/basic/position.vue"),
                      meta: {
                          can: 'cms',
                          show: true,
                          name: '职位管理',
                          font: '&#xe611;'
                      }
                  },
                  {
                      path: "/basic/position/edit",
                      component: () => import("../pages/sniper/employee/basic/positionEdit.vue"),
                      meta: {
                          can: 'cms',
                          show: false,
                          name: '添加管理',
                          font: '&#xe612;'
                      }
                  },
                  {
                      path: "/basic/employee/list",
                      component: () => import("../pages/sniper/employee/employee/list.vue"),
                      meta: {
                          can: 'cms',
                          show: true,
                          name: '员工列表',
                          font: '&#xe614;'
                      }
                  },
                  {
                      path: "/basic/employee/edit",
                      component: () => import("../pages/sniper/employee/employee/edit.vue"),
                      meta: {
                          can: 'cms',
                          show: false,
                          name: '新增员工',
                          font: '&#xe614;'
                      }
                  },
                  {
                      path: "/graph",
                      component: () => import("../pages/sniper/employee/employee/graph.vue"),
                      meta: {
                          can: 'cms',
                          show: true,
                          name: '组织架构',
                          font: '&#xe629;'
                      }
                  },
                  // {
                  //     path: "/basic",
                  //     component: () => import("../components/via.vue"),
                  //     meta: {
                  //         can: 'cms',
                  //         show: true,
                  //         name: '基础数据',
                  //         font: '&#xe612;',
                  //         type: 'title'
                  //     },
                  //     children: [
                  //
                  //     ]
                  // },
                  // {
                  //     path: "/arch",
                  //     component: () => import("../components/via.vue"),
                  //     meta: {
                  //         can: 'cms',
                  //         show: true,
                  //         name: '人员管理',
                  //         font: '&#xe612;',
                  //         type: 'title'
                  //     },
                  //     children: [
                  //
                  //     ]
                  // },
              ]
          },
        {
          path: "/privileges",
          component: () => import("../components/via.vue"),
          meta: {
            can: 'privileges',
            show: true,
            name: '权限系统',
            font: '&#xe70b;'
          },
          children: [
            {
              path: "/privileges/roles",
              component: () => import("../pages/privileges/roles.vue"),
              meta: {
                can: 'privileges list roles',
                show: true,
                name: '角色管理',
                font: '&#xe612;'
              },
            },
            {
              path: "/privileges/permissions",
              component: () => import("../pages/privileges/permissions.vue"),
              meta: {
                can: 'privileges list permissions',
                show: true,
                name: '权限管理',
                font: '&#xe70b;'
              },
            },
            {
              path: "/privileges/users",
              component: () => import("../pages/privileges/users.vue"),
              meta: {
                  can: 'privileges list permissions',
                  show: true,
                  name: '用户管理',
                  font: '&#xe70b;'
              },
            },
            {
              path: "/privileges/roles/users",
              component: () => import("../pages/privileges/roleUsers.vue"),
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
              component: () => import("../pages/privileges/rolePermissions.vue"),
              meta: {
                can: 'privileges role permissions',
                show: false,
                name: '角色权限',
                font: ''
              },
            }
          ]
        },
        {
              path: "/cms",
              component: () => import("../components/via.vue"),
              meta: {
                  can: 'cms',
                  show:true,
                  name: '内容管理',
                  font: '&#xe764;'
              },
              children: [
                  {
                      path: "/cms/content",
                      component: () => import("../pages/cms/content.vue"),
                      meta: {
                          can: 'cms list contents',
                          show: true,
                          name: '内容管理',
                          font: '&#xe764;'
                      },
                  },
                  {
                      path: "/cms/content/add",
                      component: () => import("../pages/cms/content/add.vue"),
                      meta: {
                          can: 'cms list contents',
                          show: false,
                          name: '添加内容',
                          font: '&#xe764;'
                      },
                  },
                  {
                      path: "/cms/content/edit",
                      component: () => import("../pages/cms/content/edit.vue"),
                      meta: {
                          can: 'cms list contents',
                          show: false,
                          name: '编辑内容',
                          font: '&#xe764;'
                      },
                  },
                  {
                      path: "/cms/channel",
                      component: () => import("../pages/cms/channel.vue"),
                      meta: {
                          can: 'cms list channels',
                          show: true,
                          name: '栏目管理',
                          font: '&#xe764;'
                      }
                  },
                  {
                      path: "/cms/position",
                      component: () => import("../components/via.vue"),
                      meta: {
                          can: 'cms list contents',
                          show: true,
                          name: '推荐管理',
                          font: '&#xe764;'
                      },
                      children:[
                          {
                              path: "/cms/position/position",
                              component: () => import("../pages/cms/position/position.vue"),
                              meta: {
                                  can: 'dashboard',
                                  show: true,
                                  name: '推荐位',
                                  font: '&#xe764;'
                              },
                          },
                          {
                              path: "/cms/position/content",
                              component: () => import("../pages/cms/position/content.vue"),
                              meta: {
                                  can: 'dashboard',
                                  show: false,
                                  name: '内容管理',
                                  font: '&#xe764;'
                              },
                          },
                          {
                              path: "/cms/position/subs",
                              component: () => import("../pages/cms/position/subs.vue"),
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
                      component: () => import("../pages/cms/comment/comment.vue"),
                      meta: {
                          can: 'cms list contents',
                          show: true,
                          name: '评论管理',
                          font: '&#xe764;'
                      }
                  },
                  {
                      path: "/cms/comment/content",
                      component: () => import("../pages/cms/comment/content.vue"),
                      meta: {
                          can: 'cms list contents',
                          show: false,
                          name: '文章评论',
                          font: '&#xe764;'
                      }
                  },
                  {
                      path: "/cms/setting",
                      component: () => import("../components/via.vue"),
                      meta: {
                          can: 'cms list contents',
                          show: true,
                          name: '设置',
                          font: '&#xe764;'
                      },
                      children: [
                          {
                              path: "/cms/setting/siteSetting",
                              component: () => import("../pages/cms/setting/siteSetting.vue"),
                              meta: {
                                  can: 'dashboard',
                                  show: true,
                                  name: '站点设置',
                                  font: '&#xe764;'
                              }
                          },
                          {
                              path: "/cms/setting/model",
                              component: () => import("../pages/cms/setting/model.vue"),
                              meta: {
                                  can: 'dashboard',
                                  show: true,
                                  name: '模型管理',
                                  font: '&#xe764;'
                              },
                          },
                          {
                              path: "/cms/setting/model/add",
                              component: () => import("../pages/cms/setting/modelEdit.vue"),
                              meta: {
                                  can: 'dashboard',
                                  show: false,
                                  name: '添加模型',
                                  font: '&#xe764;'
                              }
                          },
                          {
                              path: "/cms/setting/model/edit",
                              component: () => import("../pages/cms/setting/modelEdit.vue"),
                              meta: {
                                  can: 'dashboard',
                                  show: false,
                                  name: '编辑模型',
                                  font: '&#xe764;'
                              }
                          },
                          {
                              path: "/cms/setting/field/types",
                              component: () => import("../pages/cms/setting/fieldTypes.vue"),
                              meta: {
                                  can: 'dashboard',
                                  show: true,
                                  name: '字段类型',
                                  font: '&#xe764;'
                              }
                          }
                      ]
                  },
                  {
                      path: "/cms/operation",
                      component: () => import("../components/via.vue"),
                      meta: {
                          can: 'cms operations',
                          show: true,
                          name: '运营管理',
                          font: '&#xe764;'
                      },
                      children: [
                          {
                              path: "/cms/operation/orders",
                              component: () => import("../pages/cms/operation/orders.vue"),
                              meta: {
                                  can: 'cms operations',
                                  show: true,
                                  name: '订单管理',
                                  font: '&#xe764;'
                              }
                          },
                          {
                              path: "/cms/operation/ads",
                              component: () => import("../pages/cms/operation/ads.vue"),
                              meta: {
                                  can: 'cms ad operations',
                                  show: true,
                                  name: '广告管理',
                                  font: '&#xe764;'
                              }
                          },
                          {
                              path: "/cms/operation/ad/positions",
                              component: () => import("../pages/cms/operation/adPositions.vue"),
                              meta: {
                                  can: 'cms ad operations',
                                  show: true,
                                  name: '广告位',
                                  font: '&#xe764;'
                              }
                          },
                          {
                              path: "/cms/operation/edit/ad",
                              component: () => import("../pages/cms/operation/editAd.vue"),
                              meta: {
                                  can: 'cms ad operations',
                                  show: false,
                                  name: '广告位',
                                  font: '&#xe764;'
                              }
                          }
                      ]
                  }
              ]
          },
      ]
    },
    {
      path: "/login",
      component: () => import("../pages/login.vue"),
      meta: {
        name: '登录',
      },
    },
    {
        path: "/test",
        component: () => import("../pages/test.vue"),
        meta: {
            name: 'test',
        },
    }

  ]
})
