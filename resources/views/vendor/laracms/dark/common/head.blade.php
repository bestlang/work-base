
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=""> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <title>首页 - {{config('app.name')}}</title>
    <meta name="keywords" content="laracms"/>
    <meta name="description" content=""/>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
    <link rel="stylesheet" media="screen" href="/vendor/laracms/dark/common.css" />
    <link rel="stylesheet" media="screen" href="/vendor/laracms/dark/front.css" />

    <link rel="stylesheet" href="//at.alicdn.com/t/font_1104524_z1zcv22ej09.css">
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
                <a class="navbar-brand" href="/"><img src="/laracms.png" width="180" alt="LaraCMS"></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav" data-current="0">
                    <!--如果你需要自定义NAV,可使用channellist标签来完成,这里只设置了2级,如果显示无限级,请使用cms:nav标签-->
                    <!--判断是否有子级或高亮当前栏目-->
                    <li class="">
                        <a href="/">首页</a>
                        <ul class="dropdown-menu" role="menu">
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" data-toggle="dropdown" >新闻中心 <b class="caret"></b></a>
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
    <!-- E 导航 -->

</header>