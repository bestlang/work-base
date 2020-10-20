<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <title>首页 - {{config('app.name')}}</title>
    <meta name="keywords" content="laracms"/>
    <meta name="description" content=""/>
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <script src="/vendor/base/app.js"></script>
    @stack('css')
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcdn.net/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/respond.js/1.4.0/respond.min.js"></script>
    <![endif]-->
    <style>
        .l-content-title{
            font-size: 24px;
            line-height: 150%;
        }
    </style>
</head>
<body class="group-page">
<header class="header">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="/logo.png" width="180"></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav" data-current="0">
                    {{--<li class="">--}}
                        {{--<a href="/">首页</a>--}}
                        {{--<ul class="dropdown-menu" role="menu">--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">
                            会员<span class="hidden-sm">中心</span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            @guest
                            <li><a href="{{route('login')}}"><i class="fa fa-sign-in fa-fw"></i>登录</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{route('register')}}"><i class="fa fa-user-o fa-fw"></i>注册</a></li>
                            @endif
                            @else
                                <li>
                                    <a href="/ucenter">个人中心</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                @if(1)
                                    {{--{{ Gate::allows('system') }}--}}
                                    <li><a class="dropdown-item" href="/admin">
                                            {{ __('Management') }}
                                        </a></li>
                                @endif
                             @endguest
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

</header>