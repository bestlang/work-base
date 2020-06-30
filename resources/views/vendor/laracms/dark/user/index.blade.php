@extends('laracms::dark.layouts.app')

@section('content')
    <div id="content-container" class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="sidenav">
                    <ul class="list-group">
                        <li class="list-group-heading">会员中心</li>
                        <li class="list-group-item active"> <a href="/index/user/index.html"><i class="fa fa-user-circle fa-fw"></i> 会员中心</a> </li>
                        <li class="list-group-item "> <a href="/index/user/profile.html"><i class="fa fa-user-o fa-fw"></i> 个人资料</a> </li>
                        <li class="list-group-item "> <a href="/index/user/changepwd.html"><i class="fa fa-key fa-fw"></i> 修改密码</a> </li>
                        <li class="list-group-item "> <a href="/index/user/logout.html"><i class="fa fa-sign-out fa-fw"></i> 注 销</a> </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-heading">内容管理</li>
                        <!--如果需要直接跳转对应的模型(比如我的新闻,我的产品,发布新闻,发布产品)，可以在链接后加上 ?model_id=模型ID -->
                        <li class="list-group-item "><a href="/index/cms.archives/my.html"><i class="fa fa-newspaper-o fa-fw"></i> 我发布的文章</a></li>
                        <li class="list-group-item "><a href="/index/cms.archives/post.html"><i class="fa fa-pencil fa-fw"></i> 发布文章</a></li>
                        <li class="list-group-item "><a href="/index/cms.order/index.html"><i class="fa fa-shopping-bag fa-fw"></i> 我的消费订单</a></li>
                        <li class="list-group-item "><a href="/index/cms.comment/index.html"><i class="fa fa-comments fa-fw"></i> 我发表的评论</a></li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item "><a href="/index/invite/index.html"><i class="fa fa-users fa-fw"></i> 邀请好友</a></li>
                    </ul><ul class="list-group">
                        <li class="list-group-heading">充值中心</li>
                        <li class="list-group-item "><a href="/index/recharge/recharge.html"><i class="fa fa-cny fa-fw"></i> 充值余额</a></li>
                        <li class="list-group-item "><a href="/index/recharge/moneylog.html"><i class="fa fa-list fa-fw"></i> 余额日志</a></li>
                    </ul><ul class="list-group">
                        <li class="list-group-heading">投票管理</li>
                        <li class="list-group-item "><a href="/index/vote/subject.html"><i class="fa fa-pencil fa-fw"></i> 我创建的投票</a></li>
                        <li class="list-group-item "><a href="/index/vote/apply.html"><i class="fa fa-users fa-fw"></i> 我报名的投票</a></li>
                        <li class="list-group-item "><a href="/index/vote/record.html"><i class="fa fa-list fa-fw"></i> 我的投票记录</a></li>
                    </ul><ul class="list-group">
                        <li class="list-group-heading">提现中心</li>
                        <li class="list-group-item "><a href="/index/withdraw/withdraw.html"><i class="fa fa-dollar fa-fw"></i> 余额提现</a></li>
                        <li class="list-group-item "><a href="/index/withdraw/withdrawlog.html"><i class="fa fa-list fa-fw"></i> 提现日志</a></li>
                    </ul></div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default ">
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
            </div>
        </div>
    </div>
@endsection