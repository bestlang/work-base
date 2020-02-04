import router from './router/index'//路由
import store from './store/index'//路由
import custom from '../config/custom'

router.beforeEach((to, from, next) => {
  let loginPath = '/login';//custom.ADMIN_URI +
    let accessToken = localStorage.getItem('accessToken');//登录标示
    //let perms = store.state.perms.perms;//登录状态
    if (!accessToken && to.path != loginPath) {
        next(loginPath);
    } else {
        if (to.path == loginPath) {
            localStorage.setItem('accessToken', '');
            next();
        } else {
            next();
            // if (perms) {
            //     next();
            // } else {
            //     store.dispatch('setRouters').then(() => {
            //         router.addRoutes(store.state.perms.addRouters);
            //         next({ ...to }) // hack方法 确保addRoutes已完成
            //     })
            // }
        }
    }
})
