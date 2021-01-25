@extends('LaraCMS::themes.blue.layouts.app')
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
                                <li>正文</li>
                            </ol>
                        </div>
                        <div class="l-article-body">
                            <h1 class="l-content-title">{{$content->title}}</h1>
                            <div>{!! LaraCMS::content($content, 'content') !!}</div>
                            @if(count($content->attachment))
                            <ul>
                                @foreach($content->attachment as $att)
                                <li><a href="{{$att['url']}}" target="_blank">{{$att['name']}}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" id="comments">
                            <h3 class="panel-title">评论列表</h3>
                        </div>
                        <div class="panel-body">
                            <div>
                                @foreach($comments as $comment)
                                    <p>{{$comment->user?$comment->user->name:''}} says:{{$comment->content}}</p>
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
                                    <textarea class="form-control" rows="5" id="comment" style="resize: none;"></textarea>
                                    <button type="button" class="btn btn-primary" id="comment_submit">提交</button>
                                </div>
                            </form>
                            @endauth
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
                    {{----}}
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
{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
    {{--<meta charset="utf-8">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    {{--<title>{{ config('app.name') }}</title>--}}
    {{--<script type="text/javascript" src="/vendor/laracms/dark/app.js"></script>--}}
    {{--<link rel="stylesheet"--}}
          {{--href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/default.min.css">--}}
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js"></script>--}}
{{--</head>--}}
{{--<body>--}}
{{--@include('LaraCMS::dark.common.head')--}}
{{--<div class="l-content">--}}
    {{--<div class="l-content-inner l-min-height">--}}
        {{--<div class="l-row">--}}
            {{--<div class="col-md-12 l-block-content">--}}
                {{--<h1 class="l-content-title">{{$content->title}}</h1>--}}
                {{--<div>{!!  LaraCMS::content($content, 'content') !!}</div>--}}
            {{--</div>--}}
            {{--<div><h2>评论区:</h2></div>--}}
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
{{--@include('LaraCMS::dark.common.foot')--}}
{{--<script type="text/javascript">--}}
    {{--$(function(){--}}
        {{--$('#comment_submit').click(function(){--}}
            {{--const content = $('#comment').val();--}}
            {{--const contend_id = $('#content_id').val();--}}
{{--//            if(!content){--}}
{{--//                alert('评论内容不能为空');--}}
{{--//            }--}}
            {{--axios.post('/cms/comment/save', {content: content, content_id:contend_id}).then(response => {--}}
                {{--let res = response.data;--}}
                {{--if(res.success){--}}
                    {{--alert('评论成功')--}}
                    {{--location.reload()--}}
                {{--}else{--}}
                    {{--alert(JSON.stringify(res.error))--}}
                {{--}--}}
            {{--})--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}
