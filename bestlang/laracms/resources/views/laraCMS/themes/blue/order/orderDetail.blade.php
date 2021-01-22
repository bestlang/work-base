@extends('laraCMS::themes.blue.layouts.ucenter')
@section('css')
    <style>
        .btn{
            border-radius: 0;
        }
    </style>
@endsection
@section('content')
<div style="padding: 20px">
    <h2 class="page-header">
        订单详情
    </h2>
    <div style="line-height: 30px;">
        <div>商品名称: {{$order->name}}</div>
        <div>商品描述: {{$order->descrition}}</div>
        <div>订单号: {{$order->order_no}}</div>
        <div>交易金额: {{$order->money}}元</div>
    </div>
    <div style="margin-bottom: 20px;">
        <label for="optionsRadios">
            <h2 style="font-size: 16px;font-weight: normal;margin: 0;padding-top: 10px;line-height: 30px;">
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
                    <button type="button" class="btn btn-primary" id="l_paid">
                        已支付
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@endsection
@section('javascript')
    <script>
        $(function(){
            $('.l-menu-order').addClass('active');
            var order_no = "{{$order->order_no}}";
            $('#confirmPay').click(function(){
                $('#myModal').modal({backdrop: 'static'});
                var payMethod = $("[name='payMethod']:checked").val();
                if(payMethod == 'wxpay' || payMethod == 'alipay'){
                    window.open('/pay/'+payMethod+'?order_no='+order_no, '_blank');
                }
                return false;
            });
            $('#l_paid').click(function(){
                location.reload()
            })
        });
    </script>
@endsection