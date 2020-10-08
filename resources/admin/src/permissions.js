import router from './router/index'//路由
import store from './store/index'//路由
import Vue from 'vue'
import types from './store/types'
import Cookies from 'js-cookie'

router.beforeEach((to, from, next) => {
  let loginPath = '/login'
    let logined = Cookies.get(types.logined)//登录标识
    if(!logined && to.path != loginPath){
        next(loginPath)
    }else{
        if(to.path == loginPath){
            localStorage.setItem('accessToken', '')
            next()
        }else{
            const can = to.meta.can
            const privileges = localStorage.getItem(types.privileges)
            if(!privileges){
                next(loginPath)
            }
            if(privileges.indexOf(can) === -1){
                next({path:'/noPerm'})
            }
            next()
        }
    }
})

Vue.directive('permission',
    // {
    // update:
        (el, binding) => {
        const can = binding.value
        const privileges = localStorage.getItem(types.privileges)
        if(privileges.indexOf(can) === -1){
            el.parentNode.removeChild(el)
        }
    // }
    }
)
