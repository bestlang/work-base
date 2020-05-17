@extends('laracms::dark.layouts.app')

@section('content')
    <div class="l-content">
        <div class="l-content-inner l-min-height">
            <div class="l-row">
                <div class="col-md-12 l-block-content">
                    <h1 class="l-content-title">{{$content->title}}</h1>
                    @if($album = $content->album)
                        @foreach($album as $ab)
                            <img src="{{$ab->url}}" alt="">
                        @endforeach
                    @endif
                    {{--<div>{!!  LC::contents_get($content, 'content') !!}</div>--}}
                </div>
                <div><h2>评论区:</h2></div>
                <div>
                    @foreach($comments as $comment)
                        <p>{{$comment->user->name}} says:{{$comment->content}}</p>
                    @endforeach
                </div>
                @guest
                @if(Route::has('login'))
                    <a href="{{ route('login') }}">登录</a>之后发表评论
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
    </div>
@endsection
@push('script')
<script type="text/javascript">
$(function(){
    $('#comment_submit').click(function(){
        const content = $('#comment').val();
        const contend_id = $('#content_id').val();
        axios.post('/cms/comment/save', {content: content, content_id:contend_id}).then(response => {
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
{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
    {{--<meta charset="utf-8">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    {{--<title>{{ config('app.name') }}</title>--}}
    {{--<script type="text/javascript" src="/vendor/laracms/dark/app.js"></script>--}}
{{--</head>--}}
{{--<body>--}}
{{--@include('laracms::dark.common.head')--}}
{{--<div class="l-content">--}}
    {{--<div class="l-content-inner l-min-height">--}}
        {{--<div class="l-row">--}}
            {{--<div class="col-md-12 l-block-content">--}}
                {{--<h1 class="l-content-title">{{$content->title}}</h1>--}}
                {{--@if($album = $content->album)--}}
                    {{--@foreach($album as $ab)--}}
                        {{--<img src="{{$ab->url}}" alt="">--}}
                    {{--@endforeach--}}
                {{--@endif--}}
                {{--<div>{!!  LC::contents_get($content, 'content') !!}</div>--}}
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
{{--@include('laracms::dark.common.foot')--}}
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
