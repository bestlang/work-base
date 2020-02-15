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
@include('cms.dark.common.head')
<div class="l-content">
    <div class="l-content-inner">
        <div class="l-row row">
            <div class="l-pure-words">
                <div class="animated fadeInDown">email: laracms@163.com</div>
            </div>
        </div>
    </div>
</div>
@include('cms.dark.common.foot')

</body>
</html>
