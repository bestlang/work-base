const prod = require('sysEnv/prod.env')
const dev = require('sysEnv/dev.env')
export const getPrefix = function(){
    const origin = location.origin
    //是否正式环境
    if(origin.indexOf(prod.SITE_URL.slice(1,-1)) !== -1){//在域名目录下访问
        return 'ajax'
    }else{
        if(origin.indexOf(dev.SERVER_URL) !== -1){//在域名目录下访问
            return 'ajax'
        }else{ //远程访问
            return 'api'
        }
    }
}

export const formatDateTime = function(str){
    var date
    try{
        date = new Date(str)
    }catch(e){
        date = new Date()
    }
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var hour = date.getHours()
    var minute = date.getMinutes()
    var second = date.getSeconds()
    if (hour >= 1 && hour <= 9) {
        hour = "0" + hour;
    }
    if (minute >= 1 && minute <= 9) {
        minute = "0" + minute;
    }
    if (second >= 1 && second <= 9) {
        second = "0" + second;
    }
    return date.getFullYear() + '-' + month + '-' + strDate +' '+ hour + ':' + minute + ':' + second;
}

export  const genYm = function(){
    let d = new Date();
    let yyyy = d.getFullYear();
    let m = d.getMonth() + 1;
    let arr = [];
    for(let i = m; i>0; i--){
        if(String(i).length == 1){
            i = '0' + i
        }
        arr.push(yyyy+'-'+i)
    }
    yyyy--;
    for(let i = 12; i>0; i--){
        if(String(i).length == 1){
            i = '0' + i
        }
        arr.push(yyyy+'-'+i)
    }
    return arr;
}