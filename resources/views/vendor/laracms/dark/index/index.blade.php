{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
    {{--<meta charset="utf-8">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    {{--<title>{{ config('app.name') }}</title>--}}
    {{--<link rel="stylesheet" href="/vendor/laracms/dark/app.css"></head>--}}
{{--<body>--}}
{{--@include('laracms::dark.common.head')--}}
@extends('laracms::dark.layouts.app')

@section('content')
    <div class="l-content container" id="app">
        <div class="l-content-inner l-min-height">
            <div style="text-align: center;width: 100%;height: 170px;margin-bottom: 20px;color: #ccc;font-size: 100px;line-height: 170px;">Laravel</div>
            <div class="l-row">
                <div class="l-content-block">
                    <div class="l-position-block">
                        <div class="l-position-title">热点文章推荐</div>
                        <div class="l-position-items">
                            @foreach(LC::position('热点文章推荐') as $content)
                                <div class="l-position">
                                    @if($thumb = $content->ext['thumb'])
                                        <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                                    @endif
                                    <div class="l-position-right">
                                        <p><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></p>
                                        <p>{{$content->created_at}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="l-position-block">
                        <div class="l-position-title">热点文章推荐</div>
                        <div class="l-position-items">
                            @foreach(LC::position('热点文章推荐') as $content)
                                <div class="l-position">
                                    @if($thumb = $content->ext['thumb'])
                                        <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                                    @endif
                                    <div class="l-position-right">
                                        <p><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></p>
                                        <p>{{$content->created_at}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="l-content-block">
                    <div class="l-position-block">
                        <div class="l-position-title">第一个推荐位</div>
                        <div class="l-position-items">
                            @foreach(LC::position('第一个推荐位') as $content)
                                <div class="l-position">
                                    @if($thumb = $content->ext['thumb'])
                                        <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                                    @endif
                                    <div class="l-position-right">
                                        <p><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></p>
                                        <p>{{$content->created_at}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="l-content-block">
                    @foreach(LC::channel_position('首页栏目推荐') as $channel)
                        <div class="l-position-block">
                            <div class="l-position-title">
                                <div>❤{{$channel->name}}</div>
                                <div><a href="{{route('channel', $channel->id)}}">查看更多</a></div>
                            </div>
                            @foreach($channel->contents as $content)
                                <div class="l-position">
                                    @if($thumb = $content->ext['thumb'])
                                        <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                                    @endif
                                    <div class="l-position-right">
                                        <p><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></p>
                                        <p>{{$content->created_at}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
