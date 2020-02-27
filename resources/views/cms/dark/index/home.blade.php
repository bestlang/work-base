<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <script type="text/javascript" src="/js/app.js"></script>
</head>
<body>
@include('cms.dark.common.head')
<div class="l-content">
    <div class="l-content-inner l-fixed-height">
        <div class="l-row">
            <div class="col-md-12 l-block-content">
                @foreach(position('HOME_INDEX') as $content)
                    {{$content}}
                    <div><img src="{{$content->thumb}}" alt="" style="width: 100px;height: 100px;"></div>
                    <p><a href="/cms/content/{{$content->id}}">{{$content->title}}</a></p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@include('cms.dark.common.foot')
</body>
</html>
