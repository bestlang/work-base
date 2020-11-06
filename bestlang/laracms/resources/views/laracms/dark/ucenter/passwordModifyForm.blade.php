@extends('laracms::dark.layouts.ucenter')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {{--<h2 class="page-header">--}}
            {{--修改密码--}}
            {{--</h2>--}}
            <div>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">当前密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" placeholder="请输入当前密码">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="col-sm-2 control-label">新密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="new_password" placeholder="请输入新密码">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation" class="col-sm-2 control-label">重复新密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="new_password_confirmation" placeholder="请重复输入新密码">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(function(){
            $('.l-menu-password-modify').addClass('active')
        })
    </script>
@endsection