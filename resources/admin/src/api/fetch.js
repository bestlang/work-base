import axios from 'axios'
import { Message} from 'element-ui'
import app from '../main.js'

function showMessage(value) {
    return Message({
        showClose: true,
        message: value,
        type: 'error',
        duration: 3500
    });
}
axios.defaults.timeout = 50000;

axios.interceptors.request.use(config => {
    config.baseURL = app.SITE_URL + '/ajax/'
    config.timeout = 6000
    return config
}, error => {
    Promise.reject(error);// 错误提示
});

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
                location.href = '/login';
                break;
            case 402:
                showMessage(res.code + res.error);
                break;
            // case 0:
            //     location.href = '/login';
            default:
                showMessage(res.code + res.error);
                break;
        }
        return response.data;
    },
    error => {
        if (error.response.status === 401) {
            showMessage('请重新登录');
            app.$router.replace('/login');
        }
        Promise.reject(error);// 错误提示
    }
);

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

