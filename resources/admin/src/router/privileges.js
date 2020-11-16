export default [
    {
        path: "/privileges",
        component: {template:`<router-view></router-view>`},
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
    }
]