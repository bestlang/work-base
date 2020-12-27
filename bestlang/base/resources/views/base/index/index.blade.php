@extends('base::layouts.app')


@section('title')
    首页
@endsection

@section('content')
    <div class="swiper-container" id="bannerSwiper" style="padding-top: 30px;">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div style="min-height: 600px;background: #b02d2d;color: #fff;padding-top: 50px;">
                    <div class="container">
                        <div id="mainTheme" ><h1>LaraCMS</h1></div>
                        <p>开源、免费、强大的PHP内容管理系统</p>
                        <div class="subbtn">
                            <p>基于Laravel的内容管理系统</p>
                        </div>
                        <div class="mainbtn" data-swiper-parallax="-4500">
                            <p>开始使用 LaraCMS</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="bannerpagination" class="text-center"></div>
    </div>
@endsection
@push('script')
<script>
    var mySwiper = new Swiper('#bannerSwiper',{
        loop: true,
        speed:600,
        grabCursor : true,
        parallax:true,
        autoplay:{
            delay: 3000,
            //loop无效  stopOnLastSlide: true,
        },
        pagination: {
            el:'#bannerpagination',
            clickable :true,
        },
        navigation: {
            nextEl: '.arrow-right',
            prevEl: '.arrow-left',
        },
    });
</script>
@endpush
