@include('laracms::dark.common.head')
<style>
    .sidenav {
        padding: 20px 20px 10px 20px;
        margin-bottom: 20px;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #f1f1f1;
    }
    .sidenav .list-group .list-group-heading{
        margin-bottom: 20px;
        list-style-type: none;
    }
    .list-group-item{
        border:none;
    }
    .list-group-item.active{
        background-color: #002939;
    }
    .list-group-item.active a{
        color: #fff;
    }
    .page-header{
        margin-top: 10px;
        font-size: 16px;
    }
</style>
<div id="content-container" class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="sidenav">
                <ul class="list-group">
                    <li class="list-group-heading">会员中心</li>
                    <li class="list-group-item l-menu-order"> <a href="/ucenter/orders"><i class="fa fa-shopping-bag fa-fw"></i> 订单记录</a> </li>
                    <li class="list-group-item l-menu-member"> <a href=""><i class="fa fa-user-circle fa-fw"></i> 会员中心</a> </li>
                    <li class="list-group-item"> <a href=""><i class="fa fa-user-o fa-fw"></i> 个人资料</a> </li>
                    <li class="list-group-item"> <a href=""><i class="fa fa-key fa-fw"></i> 修改密码</a> </li>
                    <li class="list-group-item"> <a href=""><i class="fa fa-sign-out fa-fw"></i> 注 销</a> </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            @yield('content')
        </div>
    </div>
</div>
@include('laracms::dark.common.foot')
@yield('javascript')