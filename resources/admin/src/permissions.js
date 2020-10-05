import router from './router/index'//路由
import store from './store/index'//路由
import Vue from 'vue'

const privileges = localStorage.getItem('privileges')

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
            const can = to.meta.can
            if(privileges.indexOf(can) === -1){
                next({path:'/noPerm'})
            }
            next();
        }
    }
})

Vue.directive('permission',
    // {
    // update:
        (el, binding) => {
        const can = binding.value
        if(privileges.indexOf(can) === -1){
            el.parentNode.removeChild(el)
        }
    // }
    }
)
