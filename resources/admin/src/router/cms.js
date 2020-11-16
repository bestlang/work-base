export default [
    {
        path: "/cms",
        component: {template:`<router-view></router-view>`},
        meta: {
            can: 'cms',
            show:true,
            name: '内容管理',
            font: '&#xe764;'
        },
        children: [
            {
                path: "/cms/content",
                component: () => import("../pages/cms/content/content.vue"),
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
                component: () => import("../pages/cms/channel/channel.vue"),
                meta: {
                    can: 'cms list channels',
                    show: true,
                    name: '栏目管理',
                    font: '&#xe764;'
                }
            },
            {
                path: "/cms/position",
                component: rv,
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
                component: rv,
                meta: {
                    can: 'cms setting',
                    show: true,
                    name: '设置',
                    font: '&#xe764;'
                },
                children: [
                    {
                        path: "/cms/setting/siteSetting",
                        component: () => import("../pages/cms/setting/siteSetting.vue"),
                        meta: {
                            can: 'cms setting site',
                            show: true,
                            name: '站点设置',
                            font: '&#xe764;'
                        }
                    },
                    {
                        path: "/cms/setting/model",
                        component: () => import("../pages/cms/setting/model.vue"),
                        meta: {
                            can: 'cms setting model',
                            show: true,
                            name: '模型管理',
                            font: '&#xe764;'
                        },
                    },
                    {
                        path: "/cms/setting/model/add",
                        component: () => import("../pages/cms/setting/modelEdit.vue"),
                        meta: {
                            can: 'cms setting model',
                            show: false,
                            name: '添加模型',
                            font: '&#xe764;'
                        }
                    },
                    {
                        path: "/cms/setting/model/edit",
                        component: () => import("../pages/cms/setting/modelEdit.vue"),
                        meta: {
                            can: 'cms setting model',
                            show: false,
                            name: '编辑模型',
                            font: '&#xe764;'
                        }
                    },
                    {
                        path: "/cms/setting/field/types",
                        component: () => import("../pages/cms/setting/fieldTypes.vue"),
                        meta: {
                            can: 'cms setting fields',
                            show: true,
                            name: '字段类型',
                            font: '&#xe764;'
                        }
                    }
                ]
            },
            {
                path: "/cms/operation",
                component: rv,
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
                            name: '新增/编辑广告位',
                            font: '&#xe764;'
                        }
                    }
                ]
            }
        ]
    }
]