@extends('base::layouts.app')


@section('title')
    {{HashConfig::get('site','title')}}
@endsection

@section('content')
    {{--<script src="//at.alicdn.com/t/font_1296820_cr5tubvbx0l.js"></script>--}}
    <div class="swiper-container" id="bannerSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="l-swiper-one">
                    <div class="container">
                        <div class="text-center">
                            <div><h1>LaraCMS</h1></div>
                            <p>开源、免费、强大的PHP内容管理系统</p>
                            <div class="subbtn">
                                <p>基于Laravel+Vue构建</p>
                            </div>
                            <div>
                                <a href="/cms" id="l-view-sample" target="_blank">查看演示</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div id="bannerpagination" class="text-center"></div>--}}
    </div>
    {{--<div style="height: 300px">--}}

    {{--</div>--}}

@endsection
@push('css')
<style>
    #bannerSwiper{
        padding-top: 30px;
    }
    .l-swiper-one{
        min-height: 50vh;
        padding-top: 50px;
        color:#002939;
        padding-top: 50px;
    }
    .l-swiper-one h1{
        font-size: 46px;
        color: #002939;
        padding-bottom: 20px;
    }
    .l-swiper-one .l-swiper-sub{
        padding-top: 30px;
    }
    .l-intro{
        padding: 20px;
    }
    .l-app-icon{
        width: 40px;
        height: 40px;
    }
    .l-powered-title{

    }
    .l-powered{
        padding: 30px;
    }
    #l-view-sample{
        color: #002939;
    }
</style>
@endpush
@push('script')
<script>
//    var mySwiper = new Swiper('#bannerSwiper', {
//        loop: false,
//        speed:600,
//        grabCursor : true,
//        parallax:true,
//        autoplay:{
//            delay: 3000,
//            //loop无效  stopOnLastSlide: true,
//        },
//        pagination: {
//            el:'#bannerpagination',
//            clickable :true,
//        },
//        navigation: {
//            nextEl: '.arrow-right',
//            prevEl: '.arrow-left',
//        },
//    });
</script>
@endpush
