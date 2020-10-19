const prod = require('sysEnv/prod.env')
export const getPrefix = function(){
    const origin = location.origin
    //是否正式环境
    if(origin.indexOf(prod.SITE_URL.slice(1,-1)) !== -1){
        return 'ajax'
    }else{
        // 本地环境
        return location.origin.indexOf('8000') !== -1 ? 'ajax' : 'api'
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