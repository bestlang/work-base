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
    <div class="l-content l-content-bg">
        <div class="l-content-inner l-fixed-height">
            <div class="l-row">
                <div class="col-md-12 l-block-index">
                    <div class="l-words">
                        <div class="l-title animated bounceInUp text-center">A CMS based on Laravel and VueJs</div>
                        <div class="l-sub-title animated fadeInUp text-center">
                            <a class="nav-link" href="/cms/cms">view front</a> | <a class="nav-link" href="/admin/#/">view backend</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('laracms::dark.common.foot')
</body>
</html>
