import axios from 'axios'
import { Message } from 'element-ui'
import custom from '@/../config/custom'
import app from '../main.js'

function showMessage(value) {
    //this.$message.close();
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
            'Content-Type': 'application/json',
            'Accept': 'application/json'
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
        // 伪状态码
        switch (code) {
            case 200:
                break;
            case 301:
                break;
            case 304:
                break;
            case 401:
                showMessage(res.code + res.error);
                window.location = custom.ADMIN_URI + '/login';
                localStorage.setItem('accessToken', '');
                break;
            case 402:
                showMessage(res.code + res.error);
                break;
            default:
                showMessage(res.code + res.error);
                break;
        }
        return response.data;
    },
    // 少量非200状态码会进入这里
    error => {
        if(app.$route.path != custom.ADMIN_URI + '/login'){
            this.$message.close();
            localStorage.setItem('accessToken', '');
            showMessage('请重新登录');
            app.$router.push( custom.ADMIN_URI + '/login');
        }
        return Promise.reject(error)
    }
);

export default axios

