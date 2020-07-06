@extends('laracms::dark.layouts.ucenter')

@push('css')
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
    </style>
@endpush

@section('content')
    <div id="content-container" class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="sidenav">
                    <ul class="list-group">
                        <li class="list-group-heading">会员中心</li>
                        <li class="list-group-item active"> <a href=""><i class="fa fa-user-circle fa-fw"></i> 会员中心</a> </li>
                        <li class="list-group-item "> <a href=""><i class="fa fa-user-o fa-fw"></i> 个人资料</a> </li>
                        <li class="list-group-item "> <a href=""><i class="fa fa-key fa-fw"></i> 修改密码</a> </li>
                        <li class="list-group-item "> <a href=""><i class="fa fa-sign-out fa-fw"></i> 注 销</a> </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default ">
                    <div class="panel-body">
                        <h2 class="page-header" style="margin-top: 10px;">
                            会员中心<a href="/index/user/profile.html" class="btn btn-success pull-right"><i class="fa fa-pencil"></i>
                                个人资料</a>
                        </h2>
                        <div>
                            blabla
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection