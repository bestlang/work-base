<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{--™--}}

    <!-- Scripts -->
    <script type="text/javascript" src="/vendor/laracms/dark/app.js"></script>

    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="/vendor/laracms/dark/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        {{--shadow-sm--}}
        <nav class="navbar navbar-expand-md">
            <div class="container">
                <a class="navbar-brand l-logo-font" href="{{ url('/') }}">
                    <span>{{ config('app.name', 'Laravel') }}</span>
                    {{--<sup style="font-size: 60%;color:#999;">®</sup>--}}
                    {{--<image src="https://img.dafont.com/preview.php?text=LARACMS&ttf=dark_seed0&ext=2&size=53&psize=m&y=55" width="180"></image>--}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="/admin">
                                        {{ __('Management') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="l-foot">
        <div class="container">
            <div class="l-row">
                <div class="l-special-remark">
                    <div class="l-remark-title"><b>code for bread</b> 江苏省苏州市工业园区莲花新村一区45-105</div>
                    <div class="l-remark-content">以时间换结果. <br />日积月累,必有所成</div>
                </div>
                <div class="l-group-link"></div>
            {{--</div>--}}
        </div>
    </div>
</body>
</html>
