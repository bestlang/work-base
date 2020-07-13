@extends('laracms::dark.layouts.app')

@section('content')
    {{--<div class="container">--}}
    <div class="l-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default article-content">
                        <div class="l-article-body">
                            <h1 style="font-size: 20px;"><i class="fa fa-check-circle" aria-hidden="true"></i> 订单创建成功,请您您快付款!</h1>
                            <div style="border: 1px solid #f1f1f1;padding: 20px;">
                                <div>商品名称: {{$order->name}}</div>
                                <div>商品描述: 订单充值</div>
                                <div>订单号: {{$order->order_no}}</div>
                                <div>交易金额: {{$order->money}}元</div>
                            </div>
                            <nav class="navbar navbar-default" role="navigation">
                                <div>
                                    <div>
                                        <a style="float: left;" href="#">支付方式</a>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#identifier" data-toggle="tab">支付宝</a></li>
                                        <li><a href="#identifier2" data-toggle="tab">微信支付</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="identifier">
                                            <p>菜鸟教程是一个提供最新的web技术站点，本站免费提供了建站相关的技术文档，帮助广大web技术爱好者快速入门并建立自己的网站。菜鸟先飞早入行——学的不仅是技术，更是梦想。</p>
                                        </div>
                                        <div class="tab-pane fade" id="identifier2">
                                            <p>iOS 是一个由苹果公司开发和发布的手机操作系统。最初是于 2007 年首次发布 iPhone、iPod Touch 和 Apple
                                                TV。iOS 派生自 OS X，它们共享 Darwin 基础。OS X 操作系统是用在苹果电脑上，iOS 是苹果的移动版本。</p>
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
    .l-buy-form > div{
        /*margin-bottom: 5px;*/
    }
</style>
@endpush