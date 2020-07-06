@extends('laracms::dark.layouts.app')

@section('content')
    {{--<div class="container">--}}
    <div class="l-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default article-content">
                        <div class="panel-heading">
                            <ol class="breadcrumb">
                                @foreach(LC::breadcrumbs($content->channel) as $b)
                                    <li><a href="{{$b->url}}">{{$b->name}}</a></li>
                                @endforeach
                                <li>{{$content->title}}</li>
                            </ol>
                        </div>
                        <div class="l-article-body">
                            <div class="row" style="padding: 0 15px;margin-top: 20px;">
                                <div class="col-sm-5 text-center">
                                    @if(isset($content->ext['thumb']) && $thumb = $content->ext['thumb'])
                                        <img src="{{$thumb}}" alt="{{$content->title}}" style="width: 100%;border: 1px solid #f1f1f1;" />
                                    @endif
                                </div>
                                <div class="col-sm-7">
                                    <div><h3>商品名:{{$content->title}}</h3></div>
                                    <div><h4>价格:¥{{$content->ext['price']}}</h4></div>
                                    <div><h4>数量: <input type="text" value="1"></h4></div>
                                    <div><input type="button" value="购买"></div>
                                </div>
                            </div>
                            <h4 style="padding: 5px 0;border-top: 1px solid #f1f1f1;border-bottom: 1px solid #f1f1f1;">商品详情</h4>
                            <div>{!!  LC::content($content, 'content') !!}</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" id="comments">
                            <h3 class="panel-title">评论列表</h3>
                        </div>
                        <div class="panel-body">
                            <div>
                                @foreach($comments as $comment)
                                    <p>{{$comment->user->name}} says:{{$comment->content}}</p>
                                @endforeach
                            </div>
                            @guest
                            @if(Route::has('login'))
                                <a href="{{ route('login') }}" class="l-a">登录</a>之后发表评论
                            @endif
                            @endguest
                            @auth
                            <form>
                                <div class="form-group">
                                    <label for="comment">评论:</label>
                                    <input type="hidden" name="content_id" id="content_id" value="{{$content->id}}" />
                                    <textarea class="form-control" rows="5" id="comment"></textarea>
                                    <button type="button" class="btn btn-primary" id="comment_submit">提交</button>
                                </div>
                            </form>
                            @endauth
                        </div>
                    </div>
                    {{--<div class="l-bg-w">--}}
                    {{--<div class="container">--}}
                    {{--<div class="row">--}}
                    {{--<div class="l-article-body" style="background: #fff;padding: 15px;">--}}
                    {{--<div><h2 class="l-content-title">评论区:</h2></div>--}}
                    {{--<div>--}}
                    {{--@foreach($comments as $comment)--}}
                    {{--<p>{{$comment->user->name}} says:{{$comment->content}}</p>--}}
                    {{--@endforeach--}}
                    {{--</div>--}}
                    {{--@guest--}}
                    {{--@if(Route::has('login'))--}}
                    {{--<a href="{{ route('login') }}">登录</a>之后发表评论--}}
                    {{--@endif--}}
                    {{--@endguest--}}
                    {{--@auth--}}
                    {{--<form>--}}
                    {{--<div class="form-group">--}}
                    {{--<label for="comment">评论:</label>--}}
                    {{--<input type="hidden" name="content_id" id="content_id" value="{{$content->id}}" />--}}
                    {{--<textarea class="form-control" rows="5" id="comment"></textarea>--}}
                    {{--<button type="button" class="btn btn-primary" id="comment_submit">提交</button>--}}
                    {{--</div>--}}
                    {{--</form>--}}
                    {{--@endauth--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
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
        $('#comment_submit').click(function(){
            const content = $('#comment').val();
            const contend_id = $('#content_id').val();
//            if(!content){
//                alert('评论内容不能为空');
//            }
            axios.post('/comment/save', {content: content, content_id:contend_id}).then(response => {
                let res = response.data;
                if(res.success){
                    alert('评论成功')
                    location.reload()
                }else{
                    alert(JSON.stringify(res.error))
                }
            })
        });
    });
</script>
@endpush
@push('css')
<style>
    #comment_submit{
        margin-top: 10px;
    }
</style>
@endpush