<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}-简介">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <script type="text/javascript" src="/js/app.js"></script>
</head>
<body>
    @include('laracms::dark.common.head')
    <div class="l-content">
        <div class="l-content-inner">
            <div class="l-row row">
                <div>
                    <div class="animated fadeInDown">本系统采用PHP+Laravel+Vuejs开发</div>
                </div>
            </div>
        </div>
    </div>
    @include('laracms::dark.common.foot')
</body>
</html>
