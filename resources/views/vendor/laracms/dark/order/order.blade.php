@extends('laracms::dark.layouts.app')

@section('content')
    {{--<div class="container">--}}
    <div class="l-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default article-content">
                        <div class="l-article-body">
                            <h1>订单创建成功,请您您快付款!</h1>
                            <div>
                                <div>商品名称: 订单充值</div>
                                <div>商品描述: 订单充值-laracms-购买</div>
                                <div>订单号: 100200300400500</div>
                                <div>交易金额: 1040元</div>
                            </div>
                            <div>付款方式:
                                <div>支付宝</div>
                                <div>微信支付</div>
                            </div>
                            <div>立即支付</div>
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