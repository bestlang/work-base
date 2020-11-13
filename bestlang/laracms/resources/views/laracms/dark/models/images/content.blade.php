@extends('laracms::dark.layouts.app')
@section('title')
    {{$content->title}}
@endsection
@section('content')
    <div class="l-content container">
        <div class="l-content-inner l-min-height">
            <div class="l-row">
                <div class="l-block-content">
                    <h1 class="l-content-title">{{$content->title}}</h1>
                    @if(count($content->album))
                        <div class="swiper-container">
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    @foreach($content->album as $ab)
                                        <div class="swiper-slide" style="background-image:url('{{$ab['url']}}')">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next swiper-button-white"></div>
                                <div class="swiper-button-prev swiper-button-white"></div>
                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">
                                    @foreach($content->album as $ab)
                                        <div class="swiper-slide" style="background-image:url('{{$ab['url']}}')"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <div>{!!  laracms::content($content, 'content') !!}</div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" id="comments">
                        <h3 class="panel-title">
                            评论列表
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div>
                            @foreach($comments as $comment)
                                <p>{{$comment->user?$comment->user->name:''}} says:{{$comment->content}}</p>
                            @endforeach
                        </div>
                        @guest
                        @if(Route::has('login'))
                            <a href="{{ route('login') }}" class="l-a">登录</a>之后发表评论
                        @endif
                        @endguest
                        @auth
                        <form>
                            <div class="form-group">
                                <label for="comment">评论:</label>
                                <input type="hidden" name="content_id" id="content_id" value="{{$content->id}}" />
                                <textarea class="form-control" rows="5" id="comment"></textarea>
                                <button type="button" class="btn btn-primary" id="comment_submit">提交</button>
                            </div>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script type="text/javascript">
    $(function(){
        $('#comment_submit').click(function(){
            const content = $('#comment').val();
            const contend_id = $('#content_id').val();
            axios.post('/comment/save', {content: content, content_id:contend_id}).then(function(response){
                let res = response.data;
                if(res.success){
                alert('评论成功')
                location.reload()
                }else{
                alert(JSON.stringify(res.error))
                }
            })
        });
    });

    $(function(){
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 5,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });
        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
    });
</script>
@endpush

@push('css')
<style>
    #comment_submit{
        margin-top: 10px;
    }
    .swiper-container {
        width: 100%;
        height: 640px;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
    }

    .gallery-top {
        height: 80%;
        width: 100%;
    }

    .gallery-thumbs {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
        cursor: pointer;
    }

    .gallery-thumbs .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }
    .gallery-thumbs .swiper-slide-thumb-active {
        opacity: 1;
    }

    .article-image {
        height: 820px;
    }

    @media (max-width: 767px) {

        .article-image {
            height: 400px;
        }
    }
</style>
@endpush
