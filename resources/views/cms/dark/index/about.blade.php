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
                    <div class="animated fadeInDown">本系统采用PHP+Laravel+Vuejs开发</div>
                </div>

                <div class="flex-center position-ref full-height">
                    @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                            <a href="{{ url('/home') }}">Home</a>
                            @else
                                <a href="{{ route('login') }}">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a>
                                @endif
                                @endauth
                        </div>
                    @endif
                    <div class="content">
                        <a href="/login">登录</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('cms.dark.common.foot')

</body>
</html>
