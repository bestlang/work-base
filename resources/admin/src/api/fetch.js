import axios from 'axios'
import { Message } from 'element-ui'
import custom from '@/../config/custom'
import app from '../main.js'

function showMessage(value) {
    return Message({
        showClose: true,
        message: value,
        type: 'error',
        duration: 3500
    });
}
/**
 * 请求拦截器
 *
 */
axios.interceptors.request.use(config => {//在此处统一配置公共参数


    config.baseURL = custom.SITE_URL+'/api/'
    config.withCredentials = true // 允许携带token ,这个是解决跨域产生的相关问题
    config.timeout = 6000
    let accessToken = localStorage.getItem('accessToken')
    if (accessToken) {
        config.headers = {
            'Authorization': 'Bearer ' + accessToken,
            'Content-Type': 'application/json'
        }
    }
    return config
}, error => {

    Promise.reject(error);// 错误提示
})

/**响应拦截器 */
axios.interceptors.response.use(response => {
        let res = response.data;
        let code = parseInt(res.code)
        let error = res.error;
        // 伪状态码
        switch (code) {
            case 200:
                break;
            case 301:
                break;
            case 304:
                break;
            case 401:
                //showMessage(error ? error : "用户名或密码错误,请重新登录");

                window.location = '/login';
                localStorage.setItem('accessToken', '');
                //return Promise.reject(response);
                // if(app.$route.path != '/login'){
                //     app.$router.push('/login');
                // }
                break;
            default:
                showMessage(res.code + ':' + res.error);
                break;
        }
        return response.data;
    },
    // 少量非200状态码会进入这里
    error => {
        if(app.$route.path != '/login'){
            localStorage.setItem('accessToken', '');
            showMessage('服务器响应失败');
            app.$router.push('/login');
        }
        return Promise.reject(error)
    }
);

export default axios

