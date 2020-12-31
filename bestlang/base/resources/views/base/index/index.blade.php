@extends('base::layouts.app')


@section('title')
    LaraCMS
@endsection

@section('content')
    <script src="//at.alicdn.com/t/font_1296820_cr5tubvbx0l.js"></script>
    <div class="swiper-container" id="bannerSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="l-swiper-one">
                    <div class="container">
                        <div class="text-center">
                            {{--<div><h1>LaraCMS</h1></div>--}}
                            {{--<p>开源、免费、强大的PHP内容管理系统</p>--}}
                            {{--<div class="subbtn">--}}
                                {{--<p>基于Laravel的内容管理系统</p>--}}
                            {{--</div>--}}
                            <div>
                                <a href="" id="l-view-sample">查看演示</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div id="bannerpagination" class="text-center"></div>--}}
    </div>
    {{--<div class="container text-center l-powered-title"><h4>POWERED BY</h4></div>--}}
    {{--<div class="container l-flex l-powered">--}}
        {{--<div class="text-center">--}}
            {{--<svg class="l-app-icon" aria-hidden="true">--}}
                {{--<use xlink:href="#iconlaravel-plain"></use>--}}
            {{--</svg>--}}
            {{--<p>Laravel</p>--}}
        {{--</div>--}}
        {{--<div class="text-center">--}}
            {{--<svg class="l-app-icon" aria-hidden="true">--}}
                {{--<use xlink:href="#iconvue"></use>--}}
            {{--</svg>--}}
            {{--<p>Vue</p>--}}
        {{--</div>--}}
        {{--<div class="text-center">--}}
            {{--<svg class="l-app-icon" aria-hidden="true">--}}
                {{--<use xlink:href="#iconBootstrap-copy"></use>--}}
            {{--</svg>--}}
            {{--<p>bootstrap</p>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div style="height: 300px">

    </div>

@endsection
@push('css')
<style>
    #bannerSwiper{
        padding-top: 30px;
    }
    .l-swiper-one{
        min-height: 50vh;
        padding-top: 50px;
        color:#31708f;
        padding-top: 50px;
    }
    .l-swiper-one h1{
        font-size: 46px;
        color: #31708f;
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
        color: #31708f;
    }
</style>
@endpush
@push('script')
<script>
    var mySwiper = new Swiper('#bannerSwiper', {
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
