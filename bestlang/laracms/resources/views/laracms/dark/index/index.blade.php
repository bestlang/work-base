@extends('laracms::dark.layouts.app')

@section('content')

    <div class="container" id="content-container">

        <div class="row">
            <main class="col-md-8">
                <div class="swiper-container index-focus">
                    <div id="index-focus" class="carousel slide carousel-focus" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach(laracms::channelContents(32, 5) as $index => $content)
                                <li data-target="#index-focus" data-slide-to="{{$index}}" class="{{$index == 0 ? 'active' : ''}}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            @foreach(laracms::channelContents(32, 5) as $index => $content)
                                <div class="item {{$index == 0 ? 'active':''}}">
                                    <a href="{{$content->ext['url']}}">
                                        <div class="carousel-img" style="background-image:url('{{$content->ext['image']}}');"></div>
                                        <div class="carousel-caption hidden-xs">
                                            <h3>{{$content->title}}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <a class="left carousel-control" href="#index-focus" role="button" data-slide="prev">
                            <span class="icon-prev fa fa-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#index-focus" role="button" data-slide="next">
                            <span class="icon-next fa fa-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <div class="panel panel-default index-gallary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span>热门图集</span>
                            <div class="more">
                                @channelLink(热门图集-19-查看更多)
                            </div>
                        </h3>

                    </div>
                    <div class="panel-body">
                        <div class="related-article">
                            <div class="row">
                                @foreach(laracms::position('首页图集推荐', 4) as $content)
                                    <div class="col-sm-3 col-xs-6">
                                        <a href="{{route('content', $content->id)}}" class="img-zoom">
                                            <div class="embed-responsive embed-responsive-4by3">
                                                @if(isset($content->ext['thumb']) && $thumb = $content->ext['thumb'])
                                                <img src="{{$thumb}}" alt="{{$content->title}}" class="embed-responsive-item">
                                                @endif
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
                                    <li>@channelLink(抖音攻略-7)</li>
                                    <li>@channelLink(防疫指南-17)</li>
                                    <li>@channelLink(苏州频道-24)</li>
                                    <li>@channelLink(五花八门-15)</li>
                                    <li>@channelLink(宝宝相册-19)</li>
                                </ul>
                            </div>
                        </h3>
                    </div>
                    <div class="panel-body p-0">
                        <div class="article-list">
                            @foreach(laracms::latest('', 15) as $index => $content)
                                @if($content->model->id == 2)
                                <article class="article-item">
                                    <div class="gallery-article">
                                        <h3 class="article-title">
                                            <a href="{{route('content', $content->id)}}">{{$content->title}}</a>
                                        </h3>
                                        <div class="row">
                                            @foreach($content->ext['album'] as $index => $album)
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
                                                    @if(isset($content->ext['thumb']) && $thumb = $content->ext['thumb'])
                                                    <img src="{{$thumb}}" alt="{{$content->title}}"  />
                                                    @endif
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
                                    {{--@if($thumb = $content->ext['thumb'])--}}
                                        {{--<div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>--}}
                                    {{--@endif--}}
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
