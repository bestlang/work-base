@extends('LaraCMS::themes.blue.layouts.ucenter')
@section('css')
    <style>
        .form-control{
            box-shadow: none;
            border: 1px solid #eee;
            border-radius: 0;
        }
        .btn-primary{
            border-radius: 0;
        }
    </style>
@endsection
@section('content')
<div class="l-p20" style="padding: 20px;">
    <div>
        <h2 class="page-header">
            修改密码
        </h2>
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">当前密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="new_password" class="col-sm-2 control-label">新密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="new_password" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="new_password_confirmation" class="col-sm-2 control-label">重复新密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="new_password_confirmation" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary" id="l_submit">修改密码</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('javascript')
    <script>
        $(function(){
            $('.l-menu-password-modify').addClass('active')
            $('#l_submit').click(function(){
                //表单验证
                var password = $('#password').val();
                var new_password = $('#new_password').val();
                var new_password_confirmation = $('#new_password_confirmation').val();
                axios.post('/ajax/auth/password/modify', {password:password,new_password: new_password, new_password_confirmation: new_password_confirmation})
                    .then(response => {
                        let res = response.data;
                        if(res.hasError){
                            alert(res.error)
                        }else{
                            alert('修改成功!')
                            document.getElementById('logout-form').submit();
                        }
                })
            })
        })
    </script>
@endsection