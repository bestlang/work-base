import router from './router/index'//路由
import store from './store/index'//路由

router.beforeEach((to, from, next) => {
  let loginPath = '/login';
    let accessToken = localStorage.getItem('accessToken');//登录标识
    if (!accessToken && to.path != loginPath) {
        next(loginPath);
    } else {
        if (to.path == loginPath) {
            localStorage.setItem('accessToken', '');
            next();
        } else {
            next();
        }
    }
})
