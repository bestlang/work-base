<script src="https://unpkg.zhimg.com/jquery@2.2.4/dist/jquery.js"></script>
<script src="https://unpkg.zhimg.com/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
<link href="https://unpkg.zhimg.com/bootstrap@3.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.zhimg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.zhimg.com/swiper.js@1.0.0/index.js"></script>
<script src="https://unpkg.zhimg.com/swiper/swiper-bundle.min.js"></script>
<script>
    if(window.axios){
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }
    var token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    }
</script>
@stack('script')
</body>
</html>