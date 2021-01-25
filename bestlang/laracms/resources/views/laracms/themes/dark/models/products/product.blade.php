@extends('LaraCMS::themes.dark.layouts.app')
@section('title')
    {{$content->title}}
@endsection
@section('content')
    {{--<div class="container">--}}
    <div class="l-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default article-content">
                        <div class="panel-heading">
                            <ol class="breadcrumb">
                                @foreach(LaraCMS::breadcrumbs($content->channel) as $b)
                                    <li><a href="{{$b->url}}">{{$b->name}}</a></li>
                                @endforeach
                                <li>{{$content->title}}</li>
                            </ol>
                        </div>
                        <div class="l-article-body">
                            <div class="row" style="padding: 0 15px 15px;margin-top: 20px;">
                                <div class="col-sm-5 text-center">
                                    @if($content->thumb)
                                        <img src="{{$content->thumb}}" alt="{{$content->title}}" style="width: 100%;border: 1px solid #f1f1f1;" />
                                    @endif
                                </div>
                                <div class="col-sm-7 l-buy-form" style="display: flex;flex-flow:column wrap;justify-content: space-between;">
                                    <input type="hidden" id="content_id" value="{{$content->id}}" />
                                    @if(auth()->check())
                                        <input type="hidden" id="user_id" value="{{auth()->user()->id}}" />
                                    @endif
                                    <div><h1 style="font-size: 20px;margin-top: 0;">{{$content->title}}</h1></div>
                                    <div><h4>¥ <span style="color: red;">{{ sprintf('%.2f', $content->price)}}</span></h4></div>
                                    <div><h4>数量: <input name="num" id="num" class="num" type="number" min="1" value="1" step="1"></h4></div>
                                    <div><h4><button id="pay_btn" type="button" class="btn btn-primary">购买</button></h4></div>
                                </div>
                            </div>
                            <div style="padding: 15px 0;border-top: 1px solid #f1f1f1;">
                                <div>{!!  LaraCMS::content($content, 'content') !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">文章推荐</h3></div>
                        <div class="panel-body">
                            @foreach(LaraCMS::position('文章详情右侧推荐一') as $key => $content)
                                <div class="media">
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
    <div class="cover">
        <div style="position: relative;width: 550px;height: 550px;margin: 0 auto;text-align: center;">
            <div id="close_pay" style="cursor:pointer;position: absolute;top:0;right: 0;color: #fff;border-radius: 25px;width: 50px;height: 50px;font-size: 20px;line-height:50px;background: #2d2d2d;z-index: 0;">X</div>
            <div style="background: #fff;width: 500px;height: 500px;border-radius: 10px;margin: 25px auto;">
                <h1 style="text-align: center;padding-top: 58px;">扫码完成支付</h1>
                <img src="" alt="" id="native2_code" style="width: 200px;height: 200px;margin: 30px auto 0;">
            </div>
        </div>
    </div>
    {{--</div>--}}
@endsection
@push('script')
<script type="text/javascript">

    $(function(){
        $('#pay_btn').click(function(){
            axios.get('/user').then(response => {
                let res = response.data;
                if(res.hasError && res.error == 'Unauthenticated.'){
                    alert('需要登录')
                    top.location.href = '/login';
                }else{
                    //生成订单并跳转到订单详情
                    var decision = confirm("确定购买?")
                    if (decision){
                        var content_id = $('#content_id').val();
                        var num = $('#num').val();
                        axios.post('/order/generate', {content_id: content_id, num: num}).then(response => {
                            let res = response.data;
                            if(res.success){
                                location.href = '/order/pay/'+res.data.order_no;
                            }else{
                                if(res.code == 401){
                                    alert(res.error);
                                    top.location.href = '/login';
                                }
                            }
                        })
                    }
                }
            });

        });
//        $('#pay_btn').click(function(){
//            let content_id = $('#content_id').val();
//            let num = $("input[name='num']").val();
//            axios.post('/ajax/pay/native2', {content_id: content_id, num: num}).then(response => {
//                let res = response.data;
//                if(res.success){
//                    $('#native2_code').attr('src', res.data)
//                    $('.cover').css('visibility', 'visible')
//                }else{
//                    if(res.code == 401){
//                        alert(res.error);
//                        top.location.href = '/login';
//                    }
//                }
//            })
//        });
        $('#comment_submit').click(function(){
            const content = $('#comment').val();
            const contend_id = $('#content_id').val();
            axios.post('/comment/save', {content: content, content_id:contend_id}).then(function(response){
                let res = response.data;
                if(res.success){
                    alert('评论成功')
                    location.reload()
                }else{
                    alert(JSON.stringify(res.error))
                }
            })
        });
        $('#close_pay').click(function(){
            $('.cover').css('visibility', 'hidden')
        })
    });
</script>
@endpush
@push('css')
<style>
    .num{
        text-indent: 5px;border: 1px solid #f1f1f1;height: 36px;line-height: 36px;width: 60px;border-radius: 3px;
    }
    .l-buy-form > div{
       /*margin-bottom: 5px;*/
    }
    .cover{
        top:0;
        left:0;
        position: fixed;
        background: rgba(0,0,0,.8);
        width: 100%;
        height: 100%;
        z-index: 9998;
        display: flex;
        align-items: center;
        visibility: hidden;
    }
</style>
@endpush