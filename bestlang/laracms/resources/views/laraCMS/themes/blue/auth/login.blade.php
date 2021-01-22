@extends('laraCMS::themes.blue.layouts.app')


@section('title')
    登录 - {{HashConfig::get('site','title')}}
@endsection

@push('css')
    <style>
        .l-login-title {
            line-height: 60px;
            font-size: 16px
        }

        .l-login-title>div {
            background: #f1f1f1
        }

        .l-login-title>div a {
            display: block
        }

        .l-login-title>div a:hover {
            text-decoration: none
        }

        .l-login-title>div.active {
            background: transparent;
            font-weight: 700
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="panel l-login-panel">
                <div>
                    <div class="l-login-title l-flex-row text-center">
                        <div class="l-flex-1 active">{{ __('登录') }}</div>
                        @if (Route::has('register'))
                        <div class="l-flex-1"><a href="{{route('register')}}">{{ __('注册') }}</a></div>
                        @endif
                    </div>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('login') }}" role="form">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{ __('E-Mail邮箱') }}</label>
                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="">{{ __('密码') }}</label>

                            <div>
                                <input value="11111111" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('记住我') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary btn-block" id="btn-ajax-submit">
                                    {{ __('登录') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('忘记了您的密码?') }}
                                    </a>
                                @endif
                                <p>
                                    <small>使用第三方账号登录：</small>
                                    <a href="/qq"><img src="https://static.laracms.com/qqLogin/qq_login.png" alt=""></a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(function(){
        axios.get('/ajax/csrf').then( response => {
            var token = response.data.data;
            if(token){
                localStorage.setItem('token', token);
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
                var el = $("[name='_token']");
                if(el){
                    el.val(token);
                }
            }
        });
        $('#btn-ajax-submit').click(function(){
            //var token = $("[name='_token']").val()
            var email = $("[name='email']").val()
            var password = $("[name='password']").val()
            axios.post('/login', {email: email, password: password}).then(response => {
            var res = response.data
            if(res.success){
                var user = res.data.user
                var name = user.name
                var type = user.type
                var token = res.data.csrf
                localStorage.setItem('name', name)
                localStorage.setItem('type', type)
                localStorage.setItem('token', token)
                location.href = '/';
            }else{
                alert(Object.values(res.error).join(''))
            }
            })
        })
    })
</script>
@endpush
