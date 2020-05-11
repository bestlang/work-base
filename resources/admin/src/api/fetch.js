import axios from 'axios'
import { Message} from 'element-ui'
import app from '../main.js'

function showMessage(value) {
    //app.$message.close();
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
    //config.withCredentials = true
    config.timeout = 6000
    // let accessToken = localStorage.getItem('accessToken')
    // if (accessToken) {
    //     config.headers = {
    //         'Authorization': 'Bearer ' + accessToken,
    //         'Content-Type': 'application/json',
    //         'Accept': 'application/json'
    //     }
    // }
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
                // try{
                //     let accessToken = localStorage.getItem('accessToken');
                //     showMessage('请重新登录!');
                //     localStorage.setItem('accessToken', '');
                //     app.$router.push('/login');
                // }catch(e){
                //     app.$router.push('/login');
                // }
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

