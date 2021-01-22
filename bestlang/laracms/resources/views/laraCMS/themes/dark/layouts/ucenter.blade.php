@include('laraCMS::themes.dark.common.head')
<style>
    .sidenav {
        padding: 20px 20px 10px 20px;
        background-color: #ecf0f1;
        background-clip: padding-box;
        border-right: none;
    }
    .sidenav .list-group .list-group-heading{
        margin-bottom: 20px;
        list-style-type: none;
    }
    .list-group-item{
        background: transparent;
        border:none;
    }
    .list-group-item a{
        display: inline-block;
        width: 100%;
        height: 100%;
    }
    .list-group-item.active{
        background-color: #bdc3c7;
    }
    .list-group-item.active a{
        color: #fff;
    }
    .list-group-item a:hover{text-decoration: none;}
    .page-header{
        margin-top: 10px;
        font-size: 16px;
    }
    .l-avatar{
        height: 80px;
        border-bottom: 1px solid #ddd;
        line-height: 80px;
        text-align: center;
        margin-bottom: 10px;
    }
    .list-group-item:first-child{
        border-radius: 0;
    }
</style>
@yield('css')
<div id="content-container" class="container">
    <div style="background: #fff;">
        <div style="padding-left: 200px;position: relative;min-height: 500px;">
            <div class="sidenav" style="width: 200px;left: 0;top: 0;bottom: 0;position: absolute;">
                <div class="l-avatar">{{auth()->user()->name}}</div>
                <ul class="list-group">
                    <li class="list-group-item l-menu-member"> <a href="/ucenter"><i class="fa fa-user-circle fa-fw"></i> 会员信息</a> </li>
                    <li class="list-group-item l-menu-order"> <a href="/ucenter/orders"><i class="fa fa-shopping-bag fa-fw"></i> 订单记录</a> </li>
                    {{--<li class="list-group-item"> <a href=""><i class="fa fa-user-o fa-fw"></i> 个人资料</a> </li>--}}
                    <li class="list-group-item l-menu-password-modify"> <a href="/ucenter/password/modify"><i class="fa fa-key fa-fw"></i> 修改密码</a> </li>
                    <li class="list-group-item l-logout"> <a href="javascript:;"><i class="fa fa-sign-out fa-fw"></i> 注 销</a> </li>
                </ul>
            </div>
            <div>
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('laracms::dark.common.foot')
<script>
    $(function(){
        $('.l-logout').click(function(){

            document.getElementById('logout-form').submit();
        })
    })
</script>
@yield('javascript')