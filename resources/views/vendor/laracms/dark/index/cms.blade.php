<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="/vendor/laracms/dark/app.css"></head>
<body>
@include('laracms::dark.common.head')
<div class="l-content" id="app">
    <div class="l-content-inner l-min-height">
        <div class="l-row">
            {{--<example-component></example-component>--}}
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <div class="col-md-12 l-block-content">
                <div class="col-md-6 l-position-block">
                    <div class="l-position-title">热点文章推荐</div>
                    @foreach(LC::position('热点文章推荐') as $content)
                        <div style="display: flex;flex-flow: row nowrap;">
                            @if($thumb = $content->ext['thumb'])
                                <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                            @endif
                            <div style="display: flex;flex-flow: column;">
                                <p><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></p>
                                <p>{{$content->created_at}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <p></p>
            <p></p>
            <div class="col-md-12 l-block-content">
            <div class="col-md-6 l-position-block">
                <div class="l-position-title">第一个推荐位</div>
                @foreach(LC::position('第一个推荐位') as $content)
                    <div style="display: flex;flex-flow: row nowrap;">
                        @if($thumb = $content->ext['thumb'])
                            <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                        @endif
                        <div style="display: flex;flex-flow: column;">
                            <p><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></p>
                            <p>{{$content->created_at}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
            <p></p>
            <p></p>
            <div class="col-md-12">
                @foreach(LC::channel_position('首页栏目推荐') as $channel)
                    <div class="l-position-block">
                        <div class="l-position-title">
                            <div>❤{{$channel->name}}</div>
                            <div><a href="{{route('channel', $channel->id)}}">更多></a></div>
                        </div>
                        @foreach($channel->contents as $content)
                            <div style="display: flex;flex-flow: row nowrap;">
                                @if($thumb = $content->ext['thumb'])
                                    <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                                @endif
                                    <div style="display: flex;flex-flow: column;">
                                        <p><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></p>
                                        <p>{{$content->created_at}}</p>
                                    </div>
                            </div>
                        @endforeach
                    </div>
                    <p></p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@include('laracms::dark.common.foot')
<script type="text/javascript" src="/vendor/laracms/dark/app.js"></script>
</body>
</html>
