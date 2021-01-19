<div class="text-center" style="color: #ccc;"><i>contact: </i><a href="mailto:laracms@163.com" style="color: #ccc;"><i>laracms@163.com</i></a></div>
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
<div style="display: none;">
    <script type="text/javascript" src="https://s9.cnzz.com/z_stat.php?id=1278098748&web_id=1278098748"></script>
</div>
</body>
</html>

