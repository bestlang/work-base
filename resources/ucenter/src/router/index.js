import Vue from 'vue'
import VueRouter from 'vue-router'
import meunData from '../assets/data/menu.json'
import 'element-ui/lib/theme-chalk/index.css'

Vue.use(VueRouter)

const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
}



const routeChildrenList = []
meunData.forEach((item) => {
    if (!item.sub) {
        routeChildrenList.push(
            {
                path: item.href,
                name: item.href,
                component: (resolve) => require([`@/${item.require}`], resolve),
                meta: {
                    routerIndex: `${item.index}`, title: item.title,
                },
                props: true,
            },
        );
    } else {
        return item.sub.forEach((sub) => {
            routeChildrenList.push(
                {
                    path: sub.href,
                    name: sub.href,
                    component: (resolve) => require([`@/${sub.require}`], resolve),
                    meta: {
                        routerIndex: `${item.index}-${sub.index}`, title: sub.title,
                    },
                    props: true,
                },
            );
        });
    }
});

const routes = [
    {
        path: '/',
        component: (resolve) => require(['@/pages/menu.vue'], resolve),
        meta: { routerIndex: '1' },
        props: true,
        children: routeChildrenList,
    },
]


const router = new VueRouter({
    // mode: 'history',
    routes,
})



export default router;
