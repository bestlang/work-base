
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
    <title>首页 - 我的CMS网站</title>
    <meta name="keywords" content="laracms"/>
    <meta name="description" content=""/>

    <link rel="shortcut icon" href="https://cdn.demo.fastadmin.net/assets/img/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
    <link rel="stylesheet" media="screen" href="/vendor/laracms/dark/common.css" />

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
                    <!--判断是否有子级或高亮当前栏目-->
                    <li class="dropdown">
                        <a href="javascript:;" data-toggle="dropdown" >新闻中心 <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('channel', 7)}}">抖音攻略</a></li>
                            <li><a href="{{route('channel', 17)}}">防疫指南</a></li>
                            <li><a href="{{route('channel', 15)}}">五花八门</a></li>
                            <li><a href="{{route('channel', 18)}}">YYYY</a></li>
                        </ul>
                    </li>
                    <!--判断是否有子级或高亮当前栏目-->
                    <li class="dropdown">
                        <a href="javascript:" data-toggle="dropdown" >更多 <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="">官网</a></li>
                            <li><a href="/store.html">插件市场</a></li>
                            <li><a href="">社区</a></li>
                            <li><a href="">文档</a></li>
                        </ul>
                    </li>
                    <!--如果需要无限级请使用cms:nav标签-->

                </ul>
                <ul class="nav navbar-right hidden">
                    <ul class="nav navbar-nav">
                        <li><a href="javascript:;" class="addbookbark"><i class="fa fa-star"></i> 加入收藏</a></li>
                        <li><a href="javascript:;" class=""><i class="fa fa-phone"></i> 联系我们</a></li>
                    </ul>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="form-inline navbar-form" action="/cms/s.html" method="post">
                            <input type="hidden" name="__searchtoken__" value="957baa462e8a10487af9a7fea385ff20" />                            <div class="form-search hidden-sm hidden-md">
                                <input class="form-control" name="q" data-suggestion-url="/addons/cms/search/suggestion.html" type="text" id="searchinput" value="" placeholder="搜索">
                            </div>
                        </form>
                    </li>
                    <li class="dropdown">
                        <a href="/index/user/index" class="dropdown-toggle" data-toggle="dropdown">会员<span class="hidden-sm">中心</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @guest
                                <li><a href="{{route('login')}}"><i class="fa fa-sign-in fa-fw"></i>登录</a></li>
                                @if (Route::has('register'))
                                <li><a href="{{route('register')}}"><i class="fa fa-user-o fa-fw"></i>注册</a></li>
                                @endif
                            @else
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


@yield('content')


<footer>
    <div class="container-fluid" id="footer">
        <div class="container">
            <div class="row footer-inner">
                <div class="col-md-3 col-sm-3">
                    <div class="footer-logo">
                        <a href="#"><i class="fa fa-bookmark"></i></a>
                    </div>
                    <p class="copyright"><small>© 2017-2020. All Rights Reserved. <br>
                            LaraCMS
                        </small>
                    </p>
                </div>
                <div class="col-md-5 col-md-push-1 col-sm-5 col-sm-push-1">
                    <div class="row">
                        <div class="col-xs-4">
                            <ul class="links">
                                <li><a href="/single/26">关于我们</a></li>
                                <li><a href="/single/27">加入我们</a></li>
                                <li><a href="#">服务项目</a></li>
                                <li><a href="#">团队成员</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-4">
                            <ul class="links">
                                <li><a href="#">新闻</a></li>
                                <li><a href="#">资讯</a></li>
                                <li><a href="#">推荐</a></li>
                                <li><a href="#">博客</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-4">
                            <ul class="links">
                                <li><a href="#">服务</a></li>
                                <li><a href="#">圈子</a></li>
                                <li><a href="#">论坛</a></li>
                                <li><a href="#">广告</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-md-push-1 col-sm-push-1">
                    <div class="footer-social">
                        <a href="#"><i class="fa fa-weibo"></i></a>
                        <a href="#"><i class="fa fa-qq"></i></a>
                        <a href="#"><i class="fa fa-wechat"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="floatbtn">
    <!-- S 浮动按钮 -->


    {{--<a class="hover" href="" target="_blank">--}}
        {{--<i class="iconfont icon-pencil"></i>--}}
        {{--<em>立即<br>投稿</em>--}}
    {{--</a>--}}

    {{--<a href="javascript:;">--}}
        {{--<i class="iconfont icon-qrcode"></i>--}}
        {{--<div class="floatbtn-wrapper">--}}
            {{--<div class="qrcode"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/qrcode.png"></div>--}}
            {{--<p>微信公众账号</p>--}}
            {{--<p>微信扫一扫加关注</p>--}}
        {{--</div>--}}
    {{--</a>--}}

    <a id="back-to-top" class="hover" href="javascript:;">
        <i class="iconfont icon-backtotop"></i>
        <em>返回<br>顶部</em>
    </a>
    <!-- E 浮动按钮 -->
</div>


{{--<script type="text/javascript" src="https://cdn.demo.fastadmin.net/assets/libs/jquery/dist/jquery.min.js"></script>--}}
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
{{--<script type="text/javascript" src="https://cdn.demo.fastadmin.net/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>--}}
<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="https://cdn.demo.fastadmin.net/assets/libs/fastadmin-layer/dist/layer.js"></script>--}}
<script type="text/javascript" src="https://cdn.demo.fastadmin.net/assets/libs/art-template/dist/template-native.js"></script>
<script type="text/javascript" src="https://cdn.demo.fastadmin.net/assets/addons/cms/js/jquery.autocomplete.js"></script>
{{--<script type="text/javascript" src="https://cdn.demo.fastadmin.net/assets/addons/cms/js/swiper.min.js"></script>--}}
<script src="https://cdn.bootcdn.net/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
{{--<script type="text/javascript" src="https://cdn.demo.fastadmin.net/assets/addons/cms/js/cms.js?r=1.0.2"></script>--}}
{{--<script type="text/javascript" src="https://cdn.demo.fastadmin.net/assets/addons/cms/js/common.js?r=1.0.2"></script>--}}
@stack('script')
</body>
</html>