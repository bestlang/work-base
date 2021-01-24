export default [
    {
        path: "",
        component:  () => import("../pages/dashboard.vue"),
        meta: {
            can: '',
            show:false,
            name: '面板',
            font: '&#xe764;'
        }
    },
    {
        path: "/password/modify",
        component: () => import("../pages/passwordModify.vue"),
        meta: {
            name: '密码修改',
            show: false
        },
    },
    {
        path: "/history",
        component:  () => import("../pages/history.vue"),
        meta: {
            can: 'dashboard',
            show:true,
            name: '历史痕迹',
            font: '&#xe74d;'
        }
    },
    {
        path: "/modules",
        component:  () => import("../pages/modules.vue"),
        meta: {
            can: 'dashboard',
            show:true,
            name: '模块管理',
            font: '&#xe60e;;'
        }
    }
]