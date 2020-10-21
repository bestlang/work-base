export default [
    {
        path: '/panel',
        component: () => import('../pages/panel/layout'),
        meta: {
            can: '',
            show: false,
            name: '个人中心'
        },
        children:[
            {
                path: "",
                component:  () => import("../pages/panel/index.vue"),
                meta: {
                    can: '',
                    show:false,
                    name: '主界面',
                    font: '&#xe764;'
                }
            },
            {
                path: "/panel/attendance",
                component:  () => import("../pages/panel/attendance.vue"),
                meta: {
                    can: '',
                    show:false,
                    name: '面板',
                    font: '&#xe764;'
                }
            },
        ]
    },
]