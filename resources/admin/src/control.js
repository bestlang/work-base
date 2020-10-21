import router from './router/index'//路由
import Vue from 'vue'
import types from 'sysStore/types'
// import Cookies from 'js-cookie'
import {getPrefix} from './api/util'

router.beforeEach((to, from, next) => {
    let loginPath = '/login'
    if(getPrefix() == 'ajax' && to.path == '/'){
        next()
    }else {
        // let logined = Cookies.get(types.logined)
        // if (!logined && to.path != loginPath) {
        //     next(loginPath)
        // } else
        if (to.path == loginPath) {
            localStorage.removeItem('accessToken')
            next()
        } else {
            const can = to.meta.can
            const privileges = JSON.parse(localStorage.getItem(types.privileges))
            if (!privileges || !privileges.length) {
                next(loginPath)
            }
            if (can && privileges.indexOf(can) === -1) {
                next({path: '/no/permission'})
            }
            next()
        }
    }
})


Vue.directive('permission', {
    inserted:(el, binding) => {
        const can = binding.value
        const privileges = JSON.parse(localStorage.getItem(types.privileges))
        if(can && privileges.indexOf(can) === -1){
            el.parentNode.removeChild(el)
        }
    }
})