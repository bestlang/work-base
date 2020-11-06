import axios from 'axios'
import { Message } from 'element-ui'
import app from '../main.js'
import {getPrefix} from './util'
// import Cookies from 'js-cookie'
import types from  'sysStore/types'

const loginPath = '/login'
// axios.defaults.timeout = 50000;

axios.interceptors.request.use(config => {
    let accessToken = localStorage.getItem('accessToken')
    config.baseURL = app.SITE_URL + '/' + getPrefix() + '/'
    config.withCredentials = true
    config.timeout = 10000
    if(accessToken && getPrefix() == 'api'){
        config.headers = {
            'Authorization': 'Bearer ' + accessToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }
    // Laravel判断是否ajax请求的标准'X-Requested-With'
    config.headers['X-Requested-With'] = 'XMLHttpRequest';
    return config
}, error => {
    Promise.reject(error);// 错误提示
})

/**响应拦截器 */
axios.interceptors.response.use(response => {
        let res = response.data
        let code = parseInt(res.code)
        switch (code) {
            case 0://各种Exception导致的返回异常，包括登录超时token错误
                if(res.error !== 'Unauthenticated.'){//非登录超时异常
                    break;
                }else{
                    res.error = '登录超时，请重新登录！'
                }
            case 401:
                let msg = '请重新登录!'
                if(res.data.length){
                    msg = res.data
                }else{
                    msg = res.error
                }
                if(getPrefix() == 'api'){
                    app.showMessage(msg)
                    localStorage.removeItem('accessToken')
                    app.$router.push(loginPath)
                }else{
                    app.showMessage(msg)
                    setTimeout(() => {location.href = loginPath}, 1500)
                }
                break
            case 402:
                app.showMessage(res.code + res.error)
                break
        }
        return res
    },
    error => {
        if(getPrefix() == 'api'){
            app.$router.push(loginPath)
        }else{
            location.href = loginPath
        }
        if (error.response && error.response.status === 401){
            app.showMessage('请重新登录')
            app.$router.replace(loginPath)
        }
        Promise.reject(error)// 错误提示
    }
)

export const fetch = (url, data={}, method='get', headers=null) => {
    const config = {
        url,
        method
    }
    if(method === 'get'){
        Object.assign(config, {params: data})
    }else{
        Object.assign(config, {data})
    }
    if(headers){
        Object.assign(config, {headers})
    }
    return axios(config)
}

