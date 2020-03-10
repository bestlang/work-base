<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <script type="text/javascript" src="/laracms_static/app.js"></script>
</head>
<body>
@include('laracms::dark.common.head')
<div class="l-content">
    <div class="l-content-inner l-min-height">
        <div class="l-row">
            <div class="col-md-12 l-block-content">
                <div class="col-md-6 l-position-block">
                    <div class="l-position-title">热点文章推荐</div>
                    @foreach(LC::position('热点文章推荐') as $content)
                        <div style="display: flex;flex-flow: row nowrap;">
                            @if($thumb = LC::metas_get($content, 'thumb'))
                                <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                            @endif
                            <div style="display: flex;flex-flow: column;">
                                <p><a target="_self" href="/cms/content/{{$content->id}}">{{$content->title}}</a></p>
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
                        @if($thumb = LC::metas_get($content, 'thumb'))
                            <div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                        @endif
                        <div style="display: flex;flex-flow: column;">
                            <p><a target="_self" href="/cms/content/{{$content->id}}">{{$content->title}}</a></p>
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
                            <div><a href="/cms/channel/{{$channel->id}}">更多></a></div>
                        </div>
                        @foreach($channel->contents as $content)
                            <div style="display: flex;flex-flow: row nowrap;">
                                @if($content->thumb)
                                    <div><img src="{{$content->thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                                @endif
                                    <div style="display: flex;flex-flow: column;">
                                        <p><a target="_self" href="/cms/content/{{$content->id}}">{{$content->title}}</a></p>
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
</body>
</html>
