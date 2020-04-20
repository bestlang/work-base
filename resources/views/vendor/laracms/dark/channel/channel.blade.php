<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <script type="text/javascript" src="/vendor/laracms/dark/app.js"></script>
</head>
<body>
@include('laracms::dark.common.head')
<div class="l-content">
    <div class="l-content-inner l-min-height">
        <div class="l-row">
            <div class="col-md-12 l-block-content">
                <h1 class="l-content-title">{{$channel->name}}</h1>
                @foreach($channel->contents as $content)
                    <p><a target="_self" href="/cms/content/{{$content->id}}">{{$content->title}}</a></p>
                @endforeach
            </div>

        </div>
    </div>
</div>
@include('laracms::dark.common.foot')
</body>
</html>
