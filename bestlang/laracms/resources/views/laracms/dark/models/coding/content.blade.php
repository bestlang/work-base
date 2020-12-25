@extends('laracms::dark.layouts.app')
@section('title')
    {{$content->title}}
@endsection
@section('content')
    {{--dracula, solarized-dark, monokai-sublime, railscasts, agate, androidstudio--}}
    {{--<link rel="stylesheet" href="https://highlightjs.org/static/demo/styles/monokai-sublime.css">--}}
    <link rel="stylesheet" href="https://static.laracms.com/highlight/styles/monokai-sublime.css">
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.3.1/highlight.min.js"></script>--}}
    <script src="https://static.laracms.com/highlight/highlight.min.js"></script>
    <div class="l-content">
            <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default article-content">
                        <div class="panel-heading">
                            <ol class="breadcrumb">
                                @foreach(laracms::breadcrumbs($content->channel) as $b)
                                <li><a href="{{$b->url}}">{{$b->name}}</a></li>
                                @endforeach
                                <li>正文</li>
                            </ol>
                        </div>
                        <div class="l-article-body">
                            <h1 class="l-content-title">{{$content->title}}</h1>
                            <div>{!!  laracms::content($content, 'content') !!}</div>
                        </div>
                    </div>
                    <input type="hidden" name="content_id" id="content_id" value="{{$content->id}}" />
                    <div class="panel panel-default">
                        <div class="panel-heading" id="comments">
                            <h3 class="panel-title">评论列表</h3>
                        </div>
                        <div class="panel-body">
                            {{--<div>--}}
                                {{--@foreach($comments as $comment)--}}
                                    {{--<p>{{$comment->user ? $comment->user->name: ''}} says:{{$comment->content}}</p>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                            <div id="l-display-comments"></div>
                            {{--@guest--}}
                            {{--@if(Route::has('login'))--}}
                                {{--<a href="{{ route('login') }}" class="l-a">登录</a>之后发表评论--}}
                            {{--@endif--}}
                            {{--@endguest--}}
                            {{--@auth--}}
                            <div id="l-login-prompt" class="l-hidden"><a href="{{ route('login') }}" class="l-a">登录</a>之后发表评论</div>
                            <div id="l-comment-form" class="l-hidden">
                                <form>
                                    <div class="form-group">
                                        {{--<label for="comment">评论:</label>--}}
                                        <textarea class="form-control" rows="5" id="comment" style="resize: none;" placeholder="输入评论内容"></textarea>
                                        <button type="button" class="btn btn-primary" id="comment_submit">提交</button>
                                    </div>
                                </form>
                            </div>
                            {{--@endauth--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">文章推荐</h3></div>
                        <div class="panel-body">
                            @foreach(laracms::position('文章详情右侧推荐一') as $key => $content)
                                <div class="media">
                                    <div class="media-left">{{$key+1}}</div>
                                    <div class="media-body">
                                        <div><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            </div>

    </div>
@endsection
@push('script')
<script type="text/javascript">
    $(function(){
        var content_id = $('#content_id').val();
        function loadComments(){
            axios.get('/ajax/content/comments', {params:{content_id:content_id}}).then(function(response){
                var res = response.data;
                var html = '';
                res.data.forEach((comment) => {
                    html += "<p>" + comment.user.name + ": " + comment.content + "</p>";
                })
                $(html).appendTo('#l-display-comments');
            });
        };
        function getUserInfo(){
            axios.get('/ajax/user').then(response => {
                var res = response.data
                if(res.success){
                    var user = res.data.user;
                    if(!user){
                        $('#l-login-prompt').css({display:'block'})
                        $('#l-comment-form').css({display:'none'})
                    }else{
                        $('#l-login-prompt').css({display:'none'})
                        $('#l-comment-form').css({display:'block'})
                    }
                }else{
                    alert(Object.values(res.error).join(''))
                }
            });
        };
        setTimeout(function(){loadComments()}, 1000);
        setTimeout(function(){getUserInfo()}, 500);
        var allPreTags = document.getElementsByTagName("pre");
        for(var i = 0; i < allPreTags.length; i++)
        {
            var item = allPreTags[i];
            var itemCode = allPreTags[i].innerHTML;
            item.innerHTML = '<code>'+itemCode+'</code>';
        }
        hljs.initHighlightingOnLoad();

        $('#comment_submit').click(function(){
            var content = $('#comment').val();
            axios.post('/comment/save', {content: content, content_id:content_id}).then(function(response){
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
    .l-hidden{
        display: none;
    }
    code{
        line-height: 26px;
        font-family: Monaco,Menlo,Consolas,"Courier New",monospace;
    }
    pre{
        border-radius: 0;
        background: #fff;
        padding: 0;
        border: none;
        max-height: 99999px!important;
    }
    #comment_submit{
        margin-top: 10px;
    }
</style>
@endpush