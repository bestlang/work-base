import axios from 'axios'
import app from '../main.js'
import {getPrefix} from './util'
const loginPath = '/login'

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
        app.$message.closeAll()
        if([0, 401].indexOf(code) > -1){
            app.$message.info(res.error || '登录超时，请重新登录！')
            if(getPrefix() == 'api'){
                localStorage.removeItem('accessToken')
                app.$router.push(loginPath)
            }else{
                setTimeout(() => location.href = loginPath, 1500)
            }
        }else if(code === 402){
            res.error = res.code + res.error
        }
        return res
    },
    error => {
        app.$message.closeAll()
        app.$message.info('未知错误！请尝试重新登录')
        if(getPrefix() == 'api'){
            app.$router.push(loginPath)
        }else{
            setTimeout(() => location.href = loginPath, 1500)
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

