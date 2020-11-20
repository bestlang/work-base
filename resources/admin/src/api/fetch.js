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
        if(code === 0){
            if(res.error == 'Unauthenticated.'){//非登录超时异常
                res.error = '登录超时，请重新登录！'
                if(getPrefix() == 'api'){
                    app.$message.info(res.error)
                    localStorage.removeItem('accessToken')
                    app.$router.push(loginPath)
                }else{
                    location.href = loginPath
                }
            }
        }else if(code === 401){
            let msg = '请重新登录!'
            if(res.data.length){
                msg = res.data
            }else{
                msg = res.error
            }
            if(getPrefix() == 'api'){
                app.$message.info(msg)
                localStorage.removeItem('accessToken')
                setTimeout(() => {app.$router.push(loginPath)}, 1500)
            }else{
                location.href = loginPath
                setTimeout(() => {location.href = loginPath}, 1500)
            }
            res.error = msg
        }else if(code === 402){
            res.error = res.code + res.error
        }
        if(res.error){
            app.$message.info(res.error)
        }
        return res
    },
    error => {
        app.$message.closeAll()
        if(getPrefix() == 'api'){
            app.$router.push(loginPath)
        }else{
            location.href = loginPath
        }
        if (error.response && error.response.status === 401){
            app.$message.info('请重新登录')
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

