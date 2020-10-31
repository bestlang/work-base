
<!DOCTYPE html>
<html class="">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <title>首页 - {{HashConfig::get('site','title')}}</title>
    <meta name="keywords" content="laracms"/>
    <meta name="generator" content="laraCMS"/>
    <meta name="description" content=""/>
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    {{--<script src="/vendor/laracms/dark/app.js"></script>--}}
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.zhimg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.zhimg.com/swiper.js@1.0.0/index.js"></script>
    <script src="https://unpkg.zhimg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        if(window.axios){
            window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        }
        var token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }
    </script>
    <link href="https://unpkg.zhimg.com/normalize.css@8.0.1/normalize.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.zhimg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" media="screen" href="/vendor/laracms/dark/front.css" />
    @stack('css')
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcdn.net/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/respond.js/1.4.0/respond.min.js"></script>
    <![endif]-->


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
                <a class="navbar-brand" href="{{route('cms')}}"><img src="/vendor/laracms/dark/images/logo.png" width="180" alt="LaraCMS"></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav" data-current="0">
                    <li class="">
                        <a href="{{route('cms')}}">首页</a>
                        <ul class="dropdown-menu" role="menu">
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" data-toggle="dropdown">新闻中心 <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('channel', 7)}}">抖音攻略</a></li>
                            <li><a href="{{route('channel', 17)}}">防疫指南</a></li>
                            <li><a href="{{route('channel', 15)}}">五花八门</a></li>
                            <li><a href="{{route('channel', 18)}}">YYYY</a></li>
                            <li><a href="{{route('channel', 24)}}">苏州频道</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:" data-toggle="dropdown" >更多 <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="">官网</a></li>
                            <li><a href="">插件市场</a></li>
                            <li><a href="">社区</a></li>
                            <li><a href="">文档</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('channel', 25)}}">软件下载</a>
                    </li>
                    <li>
                        <a href="{{route('channel', 33)}}">会员充值</a>
                    </li>
                </ul>
                <ul class="nav navbar-right hidden">
                    <ul class="nav navbar-nav">
                        <li><a href="javascript:;" class="addbookbark"><i class="fa fa-star"></i> 加入收藏</a></li>
                        <li><a href="javascript:;" class=""><i class="fa fa-phone"></i> 联系我们</a></li>
                    </ul>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="form-inline navbar-form" action="#" method="get" onsubmit="location.href='/search/'+$('#searchinput').val();return false;">
                            @csrf
                            <div class="form-search hidden-sm hidden-md">
                                <input class="form-control" name="keyword" type="text" id="searchinput" value="{{$keyword??''}}" placeholder="搜索">
                            </div>
                        </form>
                    </li>
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
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                @if(auth()->user()->type == 1)
                                    {{--{{Gate::allows('system')}}--}}
                                    <li><a class="dropdown-item" href="/admin/#/">
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