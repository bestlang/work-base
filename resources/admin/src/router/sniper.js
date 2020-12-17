export default [
    {
        path: "/sniper/employee",
        component: {template:`<router-view></router-view>`},
        meta: {
            can: 'hr',
            show: true,
            name: '人力资源',
            font: '&#xe612;'
        },
        children: [
            {
                path: "/sniper/employee/department",
                component: () => import("../pages/sniper/employee/basic/department.vue"),
                meta: {
                    can: 'hr list departments',
                    show: true,
                    name: '部门管理',
                    font: '&#xe69a;'
                }
            },
            {
                path: "/sniper/employee/department/edit",
                component: () => import("../pages/sniper/employee/basic/departmentEdit.vue"),
                meta: {
                    can: 'hr add departments',
                    show: false,
                    name: '新增部门',
                    font: '&#xe612;'
                }
            },
            {
                path: "/sniper/employee/department/detail",
                component: () => import("../pages/sniper/employee/basic/departmentDetail.vue"),
                meta: {
                    can: 'hr list departments',
                    show: false,
                    name: '部门详情',
                    font: '&#xe612;'
                }
            },
            {
                path: "/sniper/employee/position",
                component: () => import("../pages/sniper/employee/basic/position.vue"),
                meta: {
                    can: 'hr positions',
                    show: true,
                    name: '职位管理',
                    font: '&#xe621;'
                }
            },
            {
                path: "/sniper/employee/position/edit",
                component: () => import("../pages/sniper/employee/basic/positionEdit.vue"),
                meta: {
                    can: 'hr positions',
                    show: false,
                    name: '编辑职位',
                    font: '&#xe612;'
                }
            },
            {
                path: "/sniper/employee/employee/list",
                component: () => import("../pages/sniper/employee/employee/list.vue"),
                meta: {
                    can: 'hr employee',
                    show: true,
                    name: '员工列表',
                    font: '&#xe614;'
                }
            },
            {
                path: "/sniper/employee/position/change",
                component: () => import("../pages/sniper/employee/employee/positionChange.vue"),
                meta: {
                    can: 'hr employee',
                    show: true,
                    name: '人事变动',
                    font: '&#xe605;'
                }
            },
            {
                path: "/sniper/employee/wastage",
                component: () => import("../pages/sniper/employee/employee/wastage.vue"),
                meta: {
                    can: 'hr employee',
                    show: true,
                    name: '离职管理',
                    font: '&#xe6d0;'
                }
            },
            {
                path: "/sniper/employee/employee/edit",
                component: () => import("../pages/sniper/employee/employee/edit.vue"),
                meta: {
                    can: 'hr employee',
                    show: false,
                    name: '新增/编辑员工',
                    font: '&#xe614;'
                }
            },
            {
                path: "/sniper/employee/employee/attendance/overview",
                component: () => import("../pages/sniper/employee/employee/attendanceOverview.vue"),
                meta: {
                    can: 'hr attendance overview',
                    show: true,
                    name: '考勤概况',
                    font: '&#xe61b;'
                }
            },
            {
                path: "/sniper/employee/employee/attendance",
                component: () => import("../pages/sniper/employee/employee/attendance.vue"),
                meta: {
                    can: 'hr attendance',
                    show: true,
                    name: '考勤记录',
                    font: '&#xe63f;'
                }
            },
            {
                path: "/sniper/employee/employee/attendance/detail",
                component: () => import("../pages/sniper/employee/employee/attendanceDetail.vue"),
                meta: {
                    can: 'hr attendance',
                    show: false,
                    name: '考勤详情',
                    font: '&#xe629;'
                }
            },
            // {
            //     path: "/graph",
            //     component: () => import("../pages/sniper/employee/employee/graph.vue"),
            //     meta: {
            //         can: 'hr attendance',
            //         show: true,
            //         name: '组织架构',
            //         font: '&#xe629;'
            //     }
            // },
            {
                path: "/train",
                component: () => import("../pages/sniper/employee/employee/train.vue"),
                meta: {
                    can: 'hr attendance',
                    show: true,
                    name: '培训记录',
                    font: '&#xe61e;'
                }
            },
            {
                path: "/train/edit",
                component: () => import("../pages/sniper/employee/employee/trainEdit.vue"),
                meta: {
                    can: 'hr attendance',
                    show: false,
                    name: '新增/编辑培训',
                    font: '&#xe61e;'
                }
            },
            {
                path: "/notice",
                component: () => import("../pages/sniper/employee/employee/notice.vue"),
                meta: {
                    can: 'hr attendance',
                    show: true,
                    name: '公告管理',
                    font: '&#xe61e;'
                }
            },
            {
                path: "/notice/edit",
                component: () => import("../pages/sniper/employee/employee/noticeEdit.vue"),
                meta: {
                    can: 'hr attendance',
                    show: true,
                    name: '新增/编辑公告',
                    font: '&#xe61e;'
                }
            },
        ]
    }
]