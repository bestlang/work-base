@extends('laracms::themes.dark.layouts.app')

@section('content')
    <div class="l-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default article-content">
                        <div class="l-article-body">
                            <h1 style="font-size: 20px;margin-top: 0;padding-top: 10px;line-height: 30px;">
                                <span class="iconfont" style="color: green">&#xe634;</span>
                                <span style="line-height: 30px;">订单创建成功,请您尽快完成支付</span>
                            </h1>
                            <div style="border: 1px solid #f1f1f1;padding: 20px;">
                                <div>商品名称: {{$order->name}}</div>
                                <div>商品描述: {{$order->descrition}}</div>
                                <div>订单号: {{$order->order_no}}</div>
                                <div>交易金额: {{$order->money}}元</div>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <label for="optionsRadios">
                                    <h2 style="font-size: 16px;margin: 0;padding-top: 10px;line-height: 30px;">
                                    请选择支付方式
                                    </h2>
                                </label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payMethod" id="optionsRadios1" value="wxpay" checked> 微信
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payMethod" id="optionsRadios2" value="alipay">支付宝
                                    </label>
                                </div>
                                <button class="btn btn-primary" id="confirmPay">点击付款</button>
                            </div>
                            {{--<nav class="navbar" role="navigation">--}}
                                {{--<div style="padding-top: 20px;">--}}
                                    {{--<div>--}}
                                        {{--<span style="float: left;display: inline-block;padding: 10px 15px;" href="#">支付方式</span>--}}
                                    {{--</div>--}}
                                    {{--<ul class="nav nav-tabs">--}}
                                        {{--<li class="active"><a href="#identifier" data-toggle="tab">微信支付</a></li>--}}
                                        {{--<li><a href="#identifier2" data-toggle="tab">支付宝</a></li>--}}
                                    {{--</ul>--}}
                                    {{--<div class="tab-content">--}}
                                        {{--<div class="tab-pane fade in active" id="identifier">--}}
                                            {{--<p>--}}
                                                {{--<p>NATIVE1</p>--}}
                                                {{--<img src="" alt="" id="native1_code" style="width: 200px;height: 200px;margin: 10px auto 0;">--}}
                                            {{--</p>--}}
                                            {{--<p>--}}
                                                {{--<p>NATIVE2</p>--}}
                                                {{--<img src="" alt="" id="native2_code" style="width: 200px;height: 200px;margin: 10px auto 0;">--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                        {{--<div class="tab-pane fade" id="identifier2">--}}
                                            {{--支付金额: ¥{{$order->money}}--}}
                                            {{--<input type="button" id="perform_alipay" value="确认支付">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</nav>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        付款提示
                    </h4>
                </div>
                <div class="modal-body">
                    请在新的标签页完成支付!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">暂时放弃
                    </button>
                    <button type="button" class="btn btn-primary" id="l_pay">
                        已支付
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@endsection
@push('script')
<script type="text/javascript">
    $(function(){
        var order_no = "{{$order->order_no}}";

        $('#confirmPay').click(function(){
            $('#myModal').modal({backdrop: 'static'});
            var payMethod = $("[name='payMethod']:checked").val();
            if(payMethod == 'wxpay' || payMethod == 'alipay'){
                window.open('/pay/'+payMethod+'?order_no='+order_no, '_blank');
            }
            return false;
        });
        $('#l_pay').click(function(){
            location.href = '/ucenter/order/detail/'+order_no
        })

//        axios.post('/ajax/pay/native1', {order_no}).then(response => {
//            let res = response.data;
//            if(res.success){
//                $('#native1_code').attr('src', res.data);
//            }else{
//                if(res.code == 401){
//                    alert(res.error);
//                    top.location.href = '/login';
//                }
//            }
//        })
//        $('#perform_alipay').click(function(){
//            axios.post('/ajax/pay/alipay/page', {order_no}).then(response => {
//                let res = response.data;
//                if(res.success){
//                    $(res.data.body).appendTo('body');
//                }else{
//                    if(res.code == 401){
//                        alert(res.error);
//                        top.location.href = '/login';
//                    }
//                }
//            })
//        })

//        axios.post('/ajax/pay/native2', {order_no}).then(response => {
//            let res = response.data;
//            if(res.success){
//                $('#native2_code').attr('src', res.data)
//            }else{
//                if(res.code == 401){
//                    alert(res.error);
//                    top.location.href = '/login';
//                }
//            }
//        })

//        $('#pay_btn').click(function(){
//            let content_id = $('#content_id').val();
//            let num = $("input[name='num']").val();
//            axios.post('/ajax/pay/native2', {content_id: content_id, num: num}).then(response => {
//                let res = response.data;
//                if(res.success){
//                    $('#native2_code').attr('src', res.data);
//                    $('.cover').css('visibility', 'visible');
//                }else{
//                    if(res.code == 401){
//                        alert(res.error);
//                        top.location.href = '/login';
//                    }
//                }
//            })
//        });
    });
</script>
@endpush
@push('css')
<style>
    .tab-content{
        padding-top: 25px;
        padding-bottom: 25px;
    }
    .l-buy-form > div{
    }
</style>
@endpush