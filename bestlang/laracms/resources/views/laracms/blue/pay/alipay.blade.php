
<!DOCTYPE html>
<html class="">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <title>支付宝支付</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
</head>
<body>
<script src="https://unpkg.zhimg.com/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://unpkg.zhimg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
    var order_no = "{{$order_no}}"
    $(function(){
        axios.post('/ajax/pay/alipay/page', {order_no}).then(response => {
            let res = response.data;
            if(res.success){
                $(res.data.body).appendTo('body')
            }else{
                if(res.code == 401){
                    alert(res.error);
                    top.location.href = '/login';
                }
            }
        })
    })
</script>
</body>
</html>
