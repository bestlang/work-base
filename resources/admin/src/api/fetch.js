import axios from 'axios'
import { Message } from 'element-ui'
//import custom from '@/../config/custom'
import _this from '../main.js'

function showMessage(value) {
    //app.$message.close();
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

    config.baseURL = _this.SITE_URL + '/api/'
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
                showMessage(res.code + res.error + '重新登录!');
                _this.$router.push( '/login');
                //window.location =  '/login';
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
    alert(_this.$router.path)
        // if(_this.$route.path != _this.ADMIN_URL + '/login'){
        //     _this.$message.close();
        //     localStorage.setItem('accessToken', '');
        //     showMessage('请重新登录');
        //     _this.$router.push( _this.ADMIN_URL + '/login');
        // }
        //return Promise.reject(error)
    }
);

export default axios

