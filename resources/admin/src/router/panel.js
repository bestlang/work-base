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
                path: "/panel/password/modify",
                component: () => import("../pages/passwordModify.vue"),
                meta: {
                    name: '密码修改',
                    show: false
                },
            },
            {
                path: "/panel/attendance",
                component:  () => import("../pages/panel/attendanceOfMine.vue"),
                meta: {
                    can: '',
                    show:false,
                    name: '面板',
                    font: '&#xe764;'
                }
            },
            {
                path: "/panel/notice",
                component:  () => import("../pages/panel/notice.vue"),
                meta: {
                    can: '',
                    show:false,
                    name: '人事公告',
                    font: '&#xe764;'
                }
            },
            {
                path: "/panel/notice/detail",
                component:  () => import("../pages/panel/noticeDetail.vue"),
                meta: {
                    can: '',
                    show:false,
                    name: '公告详情',
                    font: '&#xe764;'
                }
            },
            {
                path: "/panel/download",
                component:  () => import("../pages/panel/download.vue"),
                meta: {
                    can: '',
                    show:false,
                    name: '办事文件下载',
                    font: '&#xe764;'
                }
            },
            {
                path: "/panel/download/detail",
                component:  () => import("../pages/panel/downloadDetail.vue"),
                meta: {
                    can: '',
                    show:false,
                    name: '公告详情',
                    font: '&#xe764;'
                }
            },
        ]
    },
]