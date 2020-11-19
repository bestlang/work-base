@extends('laracms::dark.layouts.app')

@section('content')

    <div class="container" id="content-container">

        <div class="row">
            <main class="col-md-8">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach(laracms::channelContents(32, 4) as $index => $content)
                            <div class="swiper-slide">
                                <a href="{{$content->url}}">
                                    <div style="height: 100%;background:url('{{$content->image}}') scroll center/cover;"></div>
                                    {{--<div class="carousel-caption hidden-xs"><h3>{{$content->title}}</h3></div>--}}
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>

                <div class="panel panel-default index-gallary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span>热门图集</span>
                            {{--<div class="more">--}}
                                {{--<a href="{{route('channel', 19)}}">更多</a>--}}
                            {{--</div>--}}
                        </h3>

                    </div>
                    <div class="panel-body">
                        <div class="related-article">
                            <div class="row">
                                @foreach(laracms::position('首页图集推荐', 4) as $content)
                                    <div class="col-sm-3 col-xs-6">
                                        <a href="{{route('content', $content->id)}}" class="img-zoom">
                                            <div class="embed-responsive embed-responsive-4by3">

                                                <img src="{{$content->thumb}}" alt="{{$content->title}}" class="embed-responsive-item">
                                            </div>
                                        </a>
                                        <h5>{{$content->title}}</h5>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span>最近更新</span>

                            <div class="more hidden-xs">
                                <ul class="list-unstyled list-inline">
                                    {{--<li><a href=""></a></li>--}}
                                </ul>
                            </div>
                        </h3>
                    </div>
                    <div class="panel-body p-0">
                        <div class="article-list">
                            @foreach(laracms::latest(null,15) as $index => $content)
                                @if($content->model->id == 2)
                                <article class="article-item">
                                    <div class="gallery-article">
                                        <h3 class="article-title">
                                            <a href="{{route('content', $content->id)}}">{{$content->title}}</a>
                                        </h3>
                                        <div class="row">
                                            @foreach($content->album as $index => $album)
                                                @if($index > 3)
                                                    @break
                                                @endif
                                            <div class="col-sm-3 col-xs-6">
                                                <a href="{{route('content', $content->id)}}" class="img-zoom">
                                                    <div class="embed-responsive embed-responsive-4by3">
                                                        <img src="{{$album['url']}}" alt="{{$album['description']}}" class="embed-responsive-item">
                                                    </div>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="media">
                                            <div class="media-body ml-0">
                                                <div class="article-intro hidden-xs">{{$content->description}}</div>
                                                <div class="article-tag">
                                                    <a href="/cms/mobiledevice.html" class="tag tag-primary">移动设备</a>
                                                    <span itemprop="date">{{laracms::dateFormat($content->created_at)}}</span>
                                                    <span itemprop="likes" title="点赞次数"><i class="fa fa-thumbs-up"></i> 171 点赞</span>
                                                    <span itemprop="comments"><a href="/cms/mobiledevice/100.html#comments" target="_blank" title="评论数"><i class="fa fa-comments"></i> {{$content->comments()->count()}}</a> 评论</span>
                                                    <span itemprop="views" title="浏览次数"><i class="fa fa-eye"></i> 4049 浏览</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                @else
                                <article class="article-item">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="{{route('content', $content->id)}}">
                                                <div class="embed-responsive embed-responsive-4by3 img-zoom">
                                                    <img src="{{$content->thumb}}" alt="{{$content->title}}"  />
                                                </div>
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h3 class="article-title underline">
                                                <a href="{{route('content', $content->id)}}">[{{$content->channel->name}}]{{$content->title}}</a>
                                            </h3>
                                            <div class="article-intro hidden-xs">
                                                {{$content->description}}
                                            </div>
                                            <div>
                                                @foreach($content->tags as $tag)
                                                <a href="{{route('tag', $tag->name)}}" class="tag tag-primary">{{$tag->name}}</a>
                                                @endforeach
                                            </div>
                                            <div class="article-tag">
                                                <span itemprop="date">{{laracms::dateFormat($content->created_at)}}</span>
                                                <span itemprop="likes" title="点赞次数"><i class="fa fa-thumbs-up"></i> 108 点赞</span>
                                                <span itemprop="comments"><a href="{{route('content', $content->id)}}#comments" target="_blank" title="评论数"><i class="fa fa-comments"></i> {{$content->comments()->count()}}</a> 评论</span>
                                                <span itemprop="views" title="浏览次数"><i class="fa fa-eye"></i> 1250 浏览</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                @endif
                            @endforeach

                            {{--<div class="text-center">--}}
                                {{--<a href="?page=2" data-page="1" class="btn btn-default my-4 px-4 btn-loadmore">加载更多</a>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </main>

            <aside class="col-xs-12 col-sm-4">
                <div class="panel panel-default lasest-update">
                    <div class="panel-heading">
                        <h3 class="panel-title">热点文章推荐</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            @foreach(laracms::position('热点文章推荐', 5) as $content)
                                <li>
                                    <span>[<a href="{{route('channel', $content->channel->id)}}">{{$content->channel->name}}</a>]</span>
                                    <a class="link-dark" href="{{route('content', $content->id)}}" title="{{$content->title}}">{{$content->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="panel panel-blockimg">

                </div>

                @foreach(laracms::positionAds('首页右第一个广告位', 2) as $index => $ad)
                <div class="panel panel-blockimg">
                    <a href="{{$ad->url}}" target="{{$ad->target}}">
                        <img src="{{$ad->image}}" class="img-responsive">
                    </a>
                </div>
                @endforeach
                <div class="panel panel-default hot-article">
                    <div class="panel-heading">
                        <h3 class="panel-title">第一个推荐位</h3>
                    </div>
                    <div class="panel-body">
                        @foreach(laracms::position('热点文章推荐', 5) as $index => $content)
                            <div class="media media-number">
                                <div class="media-left">
                                    <span class="num">{{$index+1}}</span>
                                </div>
                                <div class="media-body">
                                    <a class="link-dark" href="{{route('content', $content->id)}}" title="{{$content->title}}">{{$content->title}}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @foreach(laracms::positionAds('首页右第一个广告位', 2) as $index => $ad)
                <div class="panel panel-blockimg">
                    <a href="{{$ad->url}}" rel="nofollow" title="{{$ad->name}}" target="{{$ad->target}}">
                        <img src="{{$ad->image}}" class="img-responsive" alt="">
                    </a>
                </div>
                @endforeach
                <div class="panel panel-default hot-tags">
                    <div class="panel-heading">
                        <h3 class="panel-title">热门标签</h3>
                    </div>
                    <div class="panel-body">
                        <div class="tags">
                            @foreach(laracms::hotTags() as $index => $tag)
                                <a href="{{route('tag', $tag->name)}}" class="tag"> <span>{{$tag->name}}</span></a>
                            @endforeach
                        </div>
                    </div>
                </div>

                @foreach(laracms::channelPosition('首页栏目推荐', 5) as $channel)
                    <div class="panel panel-default recommend-article">
                        <div class="panel-heading l-flex">
                            <h3 class="panel-title">{{$channel->name}}</h3>
                            <a class="more" href="{{route('channel', $channel->id)}}">查看更多</a>
                        </div>
                        <div class="panel-body">
                            @foreach($channel->contents as $index => $content)
                                <div class="media media-number">
                                    <div class="media-left">
                                        <span class="num">{{$index+1}}</span>
                                    </div>
                                    <div class="media-body">
                                        <a href="{{route('content', $content->id)}}" title="{{$content->title}}">{{$content->title}}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                @foreach(laracms::positionAds('首页右第一个广告位', 2) as $index => $ad)
                <div class="panel panel-blockimg">
                    <a href="{{$ad->url}}" title="{{$ad->name}}">
                        <img src="{{$ad->image}}" alt="{{$ad->name}}" class="img-responsive"/>
                    </a>
                </div>
                @endforeach
            </aside>
        </div>
    </div>
@endsection
@push('css')
<style>
    .swiper-container {
        width: 100%;
        height: 340px;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .swiper-slide a{
        display: inline-block;
        width: 100%;
        height: 100%;
    }
</style>
@endpush
@push('script')
    <script>
        var swiper = new Swiper('.swiper-container', {
            autoplay: true,
            loop: true,
            direction: 'vertical',
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
@endpush
