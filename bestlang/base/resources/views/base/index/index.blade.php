@extends('base::layouts.app')


@section('title')
    LaraCMS
@endsection

@section('content')
    <div class="swiper-container" id="bannerSwiper" style="padding-top: 30px;">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="l-swiper-one">
                    <div class="container">
                        <div><h1>LaraCMS</h1></div>
                        <div class="l-swiper-sub">
                            <p>开源、免费、强大的PHP内容管理系统</p>
                            <p>
                                <p>基于Laravel的内容管理系统</p>
                            </p>
                            <p class="mainbtn" data-swiper-parallax="-4500">
                                <p>开始使用 LaraCMS</p>
                            </p>
                        </div>
                    </div>
                    <div class="l-intro">
                        <div class="container">
                            <h2>后台基于Laravel开发</h2>
                            <h2>管理后台使用Vue+elementUI开发</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div id="bannerpagination" class="text-center"></div>--}}
    </div>

@endsection
@push('css')
<style>
    .l-swiper-one{
        min-height: 50vh;
        /*background: #b02d2d;*/
        background: #3c763d;
        color:rgba(255,255,255, .8);
        padding-top: 50px;
    }
    .l-swiper-one h1{
        color: rgba(255,255,255, .5);
        font-size: 120px;
    }
    .l-swiper-one .l-swiper-sub{
        padding-top: 30px;
    }
    .l-intro{
        padding: 20px;
    }
</style>
@endpush
@push('script')
<script>
    var mySwiper = new Swiper('#bannerSwiper',{
        loop: false,
        speed:600,
        grabCursor : true,
        parallax:true,
        autoplay:{
            delay: 3000,
            //loop无效  stopOnLastSlide: true,
        },
//        pagination: {
//            el:'#bannerpagination',
//            clickable :true,
//        },
        navigation: {
            nextEl: '.arrow-right',
            prevEl: '.arrow-left',
        },
    });
</script>
@endpush
