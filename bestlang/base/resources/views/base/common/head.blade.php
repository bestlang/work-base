<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <title>@yield('title',HashConfig::get('site','title'))</title>
    <meta name="keywords" content="laraCMS"/>
    <meta name="generator" content="laraCMS"/>
    <meta name="description" content="laraCMS"/>
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link href="https://static.laracms.com/unpkg/normalize.css" rel="stylesheet">
    <link href="https://static.laracms.com/unpkg/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://static.laracms.com/unpkg/swiper-bundle.min.css">
    <link rel="stylesheet" media="screen" href="/vendor/laracms/dark/front.css" />
    @stack('css')
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcdn.net/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/respond.js/1.4.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
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
                <a class="navbar-brand" href="/"><img src="/vendor/laracms/dark/images/logo.png" width="180" alt="LaraCMS"></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav" data-current="0">
                    <li>
                        <a href="{{route('cms')}}">系统演示</a>
                        <ul class="dropdown-menu" role="menu">
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">
                            会员<span class="hidden-sm">中心</span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" id="user-menu">
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

</header>