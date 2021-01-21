@extends('laracms::themes.dark.layouts.ucenter')
@section('content')
{{--<div class="panel panel-default">--}}
    {{--<div class="panel-body">--}}
    <div style="padding: 20px">
        <h2 class="page-header">
            会员信息
        </h2>
        {{--<a href="/index/user/profile.html" class="btn btn-success pull-right"><i class="fa fa-pencil"></i>个人资料</a>--}}
        <div>
            昵称: <span>{{auth()->user()->name}}</span>
        </div>
    </div>
    {{--</div>--}}
{{--</div>--}}
@endsection
@section('javascript')
    <script>
        $(function(){
            $('.l-menu-member').addClass('active')
        })
    </script>
@endsection