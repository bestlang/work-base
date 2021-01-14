<footer>
    <div class="container-fluid" id="footer">
        <div class="container">
            <div class="row footer-inner">
                <div class="col-md-3 col-sm-3">
                    <p class="copyright"><small>© 2017-2020. All Rights Reserved. <br>
                            LaraCMS
                        </small>
                    </p>
                </div>
                <div class="col-md-5 col-md-push-1 col-sm-5 col-sm-push-1">
                    <div class="row">
                        <div class="col-xs-4">
                            <ul class="links">
                                <li><a href="{{route('single', 26)}}">关于我们</a></li>
                                <li><a href="{{route('single', 27)}}">加入我们</a></li>
                                <li><a href="#">服务项目</a></li>
                                <li><a href="#">团队成员</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-4">
                            <ul class="links">
                                <li><a href="#">新闻</a></li>
                                <li><a href="#">资讯</a></li>
                                <li><a href="#">推荐</a></li>
                                <li><a href="#">博客</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-4">
                            <ul class="links">
                                <li><a href="#">服务</a></li>
                                <li><a href="#">圈子</a></li>
                                <li><a href="#">论坛</a></li>
                                <li><a href="#">广告</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-md-push-1 col-sm-push-1">
                    <div class="footer-social">
                        <a href="#"><i class="fa fa-weibo"></i></a>
                        <a href="#"><i class="fa fa-qq"></i></a>
                        <a href="#"><i class="fa fa-wechat"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://static.laracms.com/unpkg/jquery.min.js"></script>
<script src="https://static.laracms.com/unpkg/bootstrap.min.js"></script>
<script src="https://static.laracms.com/unpkg/axios.min.js"></script>
<script src="https://static.laracms.com/unpkg/swiper-bundle.min.js"></script>
<script>
    if(window.axios){
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }
    //var token = document.head.querySelector('meta[name="csrf-token"]');
    var token = localStorage.getItem('token');
    if(token){
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        var el = $("[name='_token']");
        if(el){
            el.val(token);
        }
    }
    var name = localStorage.getItem('name');

    if(name != 'null'){
        var type = parseInt(localStorage.getItem('type'));
        var authHtml = [
            '<li><a href="/ucenter">个人中心</a></li>',
            '<li><a href="javascript:;" id="logout-btn">登出</a></li>'
        ];
        if(type === 1){
            authHtml.unshift(
                '<li><a href="/admin/#/">管理后台</a></li>'
            );
        }
        $('#user-menu').html(authHtml.join(''))
    }

    $(document).on('click', '#logout-btn', function(){
        //$('#logout-form').submit();
        axios.post('{{ route('logout') }}').then(response => {
            localStorage.removeItem('name')
            localStorage.removeItem('type')
            localStorage.removeItem('token')
            location.href = '/'
        });
    })
</script>
@stack('script')
</body>
</html>