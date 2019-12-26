import Vue from 'vue'
import router from '@/router/index'

var chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
function generateMixed(n) {
    var res = "";
    for (var i = 0; i < n; i++) {
        var id = Math.ceil(Math.random() * 35);
        res += chars[id];
    }
    return res;
}
export default {
    install(Vue, options) {
        /**
         * path 路径
         * params {}
         * id
         */
        Vue.prototype.routerLink = function () {
            let params = {};
            let path = arguments[0] ? arguments[0] : null;
            params['type'] = arguments[1] ? arguments[1] : null;
            params['id'] = arguments[2] ? arguments[2] : 0;
            params['noce_str'] = generateMixed(7);
            let obj = arguments[3] ? arguments[3] : null;

            if (obj != null) {
                if (typeof obj == "object") {
                    for (let key in obj) {
                        params[key] = obj[key];
                    }
                } else {
                    throw new Exception("路由链接函数第四个参数只支持object类型");
                }
            }

            router.push({
                    path: path,
                    query: params
            })
        }
        //成功全局方法
        Vue.prototype.successMessage = function (value) {
            this.$message({
                showClose: true,
                message: value,
                type: 'success',
                duration: 1000
            });
        }
        Vue.prototype.errorMessage = function (value) {
            this.$message({
                showClose: true,
                message: value,
                type: 'error',
                duration: 2500
            });
        }
        Vue.prototype.$getUrl = function () {
        }
        Vue.prototype.$reset = function () {
            window.location.reload();
        }
        //获取当前时间
        Vue.prototype.$getNowDate = function () {
            var date = new Date();
            var seperator1 = "-";
            var seperator2 = ":";
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate;
            return currentdate;
        }

    }
}
