@extends('laracms::dark.layouts.ucenter')
@section('content')
<div class="panel panel-default">
    <div class="panel-body">
        <h2 class="page-header">
            会员中心<a href="/index/user/profile.html" class="btn btn-success pull-right"><i class="fa fa-pencil"></i>
                个人资料</a>
        </h2>
        <div>
            blabla
        </div>
    </div>
</div>
@endsection
@section('javascript')
    <script>
        $(function(){
            $('.l-menu-member').addClass('active')
        })
    </script>
@endsection