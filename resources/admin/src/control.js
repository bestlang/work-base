import router from './router/index'//路由
import Vue from 'vue'
import types from 'sysStore/types'
import {getPrefix} from './api/util'

router.beforeEach((to, from, next) => {
    let loginPath = '/login'
    if ([loginPath, '/'].indexOf(to.path) !== -1) {//不验权
        next();
    }else{//验权
        const can = to.meta.can
        if(can){//需要验权
            const privileges = JSON.parse(localStorage.getItem(types.privileges))
            if (!privileges || !privileges.length) {
                next(loginPath)
            }
            if (can && privileges.indexOf(can) === -1) {
                next({path: '/no/permission'})
            }
        }
        next()
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