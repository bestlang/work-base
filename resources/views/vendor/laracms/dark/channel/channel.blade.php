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
                {{--<h1 class="l-content-title">{{$channel->name}}</h1>--}}
                {{--@foreach($channel->contents as $content)--}}
                    {{--<p><a target="_self" href="/cms/content/{{$content->id}}">{{$content->title}}</a></p>--}}
                {{--@endforeach--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--@include('laracms::dark.common.foot')--}}
{{--</body>--}}
{{--</html>--}}
@extends('laracms::dark.layouts.app')
@section('content')
    <div class="">
        <div class="">
            <div class="container">
                <h1 class="category-title">
                    {{$channel->name}}
                    <div class="more pull-right">
                        <ol class="breadcrumb">
                            <!-- S 面包屑导航 -->
                            @foreach(LC::breadcrumbs($channel) as $b)
                                <li><a href="{{$b->url}}">{{$b->name}}</a></li>
                            @endforeach
                            <!-- E 面包屑导航 -->
                        </ol>
                    </div>
                </h1>
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <span>列表</span>
                                    <div class="more">
                                        <ul class="list-unstyled list-inline category-order clearfix">
                                            <!-- S 排序 -->
                                            <li><a href="?filter%5B0%5D=&amp;orderby=default&amp;orderway=asc" class="active">默认</a></li>
                                            <li><a href="?filter%5B0%5D=&amp;orderby=views&amp;orderway=desc" class="">浏览次数</a></li>
                                            <li><a href="?filter%5B0%5D=&amp;orderby=id&amp;orderway=desc" class="">发布日期</a></li>
                                            <!-- E 排序 -->
                                        </ul>
                                    </div>
                                </h3>
                            </div>
                            <div class="panel-body">
                                @foreach($contents as $content)
                                    {{--{{$content}}--}}
                                    <article class="article-item" style="padding: 20px 0;border-bottom: 1px solid #efefef;">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="{{route('content', $content->id)}}" style="width: 160px;display: block;">
                                                    <div class="embed-responsive embed-responsive-4by3 img-zoom">
                                                        @if(isset($content->ext['thumb']) && $thumb = $content->ext['thumb'])
                                                            <img src="{{$thumb}}" alt="{{$content->title}}"  />
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="media-body" style="position: relative;">
                                                <h3 class="article-title" style="margin: 0;font-size: 1.25em;">
                                                    <a href="{{route('content', $content->id)}}">{{$content->title}}</a>
                                                </h3>
                                                <div class="article-intro hidden-xs" style="line-height: 22px;">
                                                    {{$content->description}}
                                                </div>
                                                <div class="articlee-tag">
                                                    @foreach($content->tags as $tag)
                                                        <a href="/cms/internet.html" class="tag tag-primary">{{$tag->name}}</a>
                                                    @endforeach
                                                </div>
                                                <div style="position: absolute;bottom: 0;">

                                                    <span itemprop="date">2018年04月17日</span>
                                                    <span itemprop="likes" title="点赞次数"><i class="fa fa-thumbs-up"></i> 233 点赞</span>
                                                    <span itemprop="comments"><a href="/cms/internet/33.html#comments" target="_blank" title="评论数"><i class="fa fa-comments"></i> 0</a> 评论</span>
                                                    <span itemprop="views" title="浏览次数"><i class="fa fa-eye"></i> 7074 浏览</span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                                <div class="text-center pager"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading"><div class="l-position-title">文章推荐</div></div>
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
                            <div class="panel-heading"><div class="l-position-title">文章推荐</div></div>
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
    </div>
@endsection
