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
        // 伪状态码
        switch (code) {
            case 0://token信息过期
            case 401:
                if(getPrefix() == 'api'){
                    let msg = '请重新登录!'
                    if(res.data.length){
                        msg = res.data
                    }
                    app.showMessage('请重新登录!')
                    localStorage.removeItem('accessToken')
                    //Cookies.remove(types.logined)
                    app.$router.push(loginPath)
                }else{
                    location.href = loginPath
                }
                break
            case 402:
                app.showMessage(res.code + res.error)
                break
            default:
                break
        }
        return response.data
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

