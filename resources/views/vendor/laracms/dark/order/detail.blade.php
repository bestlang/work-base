@extends('laracms::dark.layouts.app')

@section('content')
    {{--<div class="container">--}}
    <div class="l-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default article-content">
                        <div class="l-article-body">
                            <h1 style="font-size: 20px;margin-top: 0;padding-top: 10px;line-height: 30px;">
                                <i style="color: green;font-size: 30px;display: inline-block;vertical-align: bottom;" class="fa fa-check-circle" aria-hidden="true"></i>
                                <span style="line-height: 30px;">订单创建成功,请您尽快完成支付</span>
                            </h1>
                            <div style="border: 1px solid #f1f1f1;padding: 20px;">
                                <div>商品名称: {{$order->name}}</div>
                                <div>商品描述: 订单充值</div>
                                <div>订单号: {{$order->order_no}}</div>
                                <div>交易金额: {{$order->money}}元</div>
                            </div>
                            <nav class="navbar" role="navigation">
                                <div style="padding-top: 20px;">
                                    <div>
                                        <span style="float: left;display: inline-block;padding: 10px 15px;" href="#">支付方式</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#identifier" data-toggle="tab">微信支付</a></li>
                                        <li><a href="#identifier2" data-toggle="tab">支付宝</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="identifier">
                                            <p>
                                                <p>NATIVE1</p>
                                                <img src="" alt="" id="native1_code" style="width: 200px;height: 200px;margin: 10px auto 0;">
                                            </p>
                                            {{--<p>--}}
                                                {{--<p>NATIVE2</p>--}}
                                                {{--<img src="" alt="" id="native2_code" style="width: 200px;height: 200px;margin: 10px auto 0;">--}}
                                            {{--</p>--}}
                                        </div>
                                        <div class="tab-pane fade" id="identifier2">
                                            支付宝支付
                                            {{--<p>--}}
                                                {{--iOS 是一个由苹果公司开发和发布的手机操作系统。最初是于 2007 年首次发布 iPhone、iPod Touch 和 Apple--}}
                                                {{--TV。iOS 派生自 OS X，它们共享 Darwin 基础。OS X 操作系统是用在苹果电脑上，iOS 是苹果的移动版本。--}}
                                            {{--</p>--}}
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">文章推荐</h3></div>
                        <div class="panel-body">
                            @foreach(LC::position('文章详情右侧推荐一') as $key => $content)
                                <div class="media">
                                    {{--@if($thumb = $content->ext['thumb'])--}}
                                    {{--<div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>--}}
                                    {{--@endif--}}
                                    <div class="media-left">{{$key+1}}</div>
                                    <div class="media-body">
                                        <div><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></div>
                                        {{--<p>{{$content->created_at}}</p>--}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{----}}
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">文章推荐</h3></div>
                        <div class="panel-body">
                            @foreach(LC::position('文章详情右侧推荐一') as $key => $content)
                                <div class="media">
                                    {{--@if($thumb = $content->ext['thumb'])--}}
                                    {{--<div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>--}}
                                    {{--@endif--}}
                                    <div class="media-left">{{$key+1}}</div>
                                    <div class="media-body">
                                        <div><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></div>
                                        {{--<p>{{$content->created_at}}</p>--}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--</div>--}}
@endsection
@push('script')
<script type="text/javascript">
    $(function(){
        var order_no = "{{$order->order_no}}"

        axios.post('/ajax/pay/native1', {order_no}).then(response => {
            let res = response.data;
            if(res.success){
                $('#native1_code').attr('src', res.data)
            }else{
                if(res.code == 401){
                    alert(res.error);
                    top.location.href = '/login';
                }
            }
        })

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

        $('#pay_btn').click(function(){
            let content_id = $('#content_id').val();
            let num = $("input[name='num']").val();
            axios.post('/ajax/pay/native2', {content_id: content_id, num: num}).then(response => {
                let res = response.data;
                if(res.success){
                    $('#native2_code').attr('src', res.data)
                    $('.cover').css('visibility', 'visible')
                }else{
                    if(res.code == 401){
                        alert(res.error);
                        top.location.href = '/login';
                    }
                }
            })
        });
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