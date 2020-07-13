@extends('laracms::dark.layouts.app')

@section('content')

    <div class="container" id="content-container">

        <!--<div style="margin-bottom:20px;">-->
        <!---->
        <!--</div>-->

        <div class="row">
            <main class="col-md-8">
                <div class="swiper-container index-focus">
                    <!-- S 焦点图 -->
                    <div id="index-focus" class="carousel slide carousel-focus" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach(LC::cc(32, 5) as $index => $content)
                                <li data-target="#index-focus" data-slide-to="{{$index}}" class="{{$index == 0 ? 'active' : ''}}"></li>
                            @endforeach
                            {{--<li data-target="#index-focus" data-slide-to="1" class=""></li>--}}
                            {{--<li data-target="#index-focus" data-slide-to="2" class=""></li>--}}
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            {{--<div class="item active">--}}
                                {{--<a href="">--}}
                                    {{--<div class="carousel-img" style="background-image:url('/lunbo/1000417-3.png');"></div>--}}
                                    {{--<div class="carousel-caption hidden-xs">--}}
                                        {{--<h3>首页焦点图标题3</h3>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<a href="">--}}
                                    {{--<div class="carousel-img" style="background-image:url('/lunbo/1000417-2.png');"></div>--}}
                                    {{--<div class="carousel-caption hidden-xs">--}}
                                        {{--<h3>首页焦点图标题2</h3>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            @foreach(LC::cc(32, 5) as $index => $content)
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
                    <!-- E 焦点图 -->
                </div>

                <div class="panel panel-default index-gallary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span>热门图集</span>
                            <div class="more">
                                <a href="{{route('channel', 19)}}">查看更多</a>
                            </div>
                        </h3>

                    </div>
                    <div class="panel-body">
                        <div class="related-article">
                            <div class="row">
                                @foreach(LC::position('首页图集推荐', 4) as $content)
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
                                    <!-- E 栏目筛选 -->
                                    <li><a href="{{route('channel', 7)}}">抖音攻略</a></li>
                                    <li><a href="{{route('channel', 17)}}">防疫指南</a></li>
                                    <li><a href="{{route('channel', 24)}}">苏州频道</a></li>
                                    <li><a href="{{route('channel', 15)}}">五花八门</a></li>
                                    <li><a href="{{route('channel', 19)}}">宝宝相册</a></li>
                                    <!-- E 栏目筛选 -->
                                </ul>
                            </div>
                        </h3>
                    </div>
                    <div class="panel-body p-0">
                        <div class="article-list">
                            @foreach(LC::latest('', 15) as $index => $content)
                                @if($content->model->id == 2)
                                <article class="article-item">
                                    <div class="gallery-article">
                                        <h3 class="article-title">
                                            <a href="{{route('content', $content->id)}}" >{{$content->title}}</a>
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
                                                    <span itemprop="date">{{LC::dateFormat($content->created_at)}}</span>
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
                                            <h3 class="article-title">
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
                                                <span itemprop="date">{{LC::dateFormat($content->created_at)}}</span>
                                                <span itemprop="likes" title="点赞次数"><i class="fa fa-thumbs-up"></i> 108 点赞</span>
                                                <span itemprop="comments"><a href="{{route('content', $content->id)}}#comments" target="_blank" title="评论数"><i class="fa fa-comments"></i> {{$content->comments()->count()}}</a> 评论</span>
                                                <span itemprop="views" title="浏览次数"><i class="fa fa-eye"></i> 1250 浏览</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                @endif
                            @endforeach
                            <!-- E 首页列表 -->

                            {{--<div class="text-center">--}}
                                {{--<a href="?page=2" data-page="1" class="btn btn-default my-4 px-4 btn-loadmore">加载更多</a>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </main>

            <aside class="col-xs-12 col-sm-4">
                <div class="panel panel-default lasest-update">
                    <!-- S 最近更新 -->
                    <div class="panel-heading">
                        <h3 class="panel-title">热点文章推荐</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            @foreach(LC::position('热点文章推荐', 5) as $content)
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

                @foreach(LC::pa('首页右第一个广告位', 2) as $index => $ad)
                <div class="panel panel-blockimg">
                    <a href="{{$ad->url}}" target="{{$ad->target}}">
                        <img src="{{$ad->image}}" class="img-responsive">
                    </a>
                </div>
                @endforeach
                <!-- S 热门资讯 -->
                <div class="panel panel-default hot-article">
                    <div class="panel-heading">
                        <h3 class="panel-title">第一个推荐位</h3>
                    </div>
                    <div class="panel-body">
                        @foreach(LC::position('热点文章推荐', 5) as $index => $content)
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
                <!-- E 热门资讯 -->
                @foreach(LC::pa('首页右第一个广告位', 2) as $index => $ad)
                <div class="panel panel-blockimg">
                    <a href="{{$ad->url}}" rel="nofollow" title="{{$ad->name}}" target="{{$ad->target}}">
                        <img src="{{$ad->image}}" class="img-responsive" alt="">
                    </a>
                </div>
                @endforeach
                <!-- S 热门标签 -->
                <div class="panel panel-default hot-tags">
                    <div class="panel-heading">
                        <h3 class="panel-title">热门标签</h3>
                    </div>
                    <div class="panel-body">
                        <div class="tags">
                            @foreach(LC::hot_tags() as $index => $tag)
                                <a href="{{route('tag', $tag->name)}}" class="tag"> <span>{{$tag->name}}</span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- E 热门标签 -->

                <!-- S 推荐下载 -->
                @foreach(LC::channel_position('首页栏目推荐', 5) as $channel)
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
                <!-- E 推荐下载 -->
                @foreach(LC::pa('首页右第一个广告位', 2) as $index => $ad)
                <div class="panel panel-blockimg">
                    <a href="{{$ad->url}}" title="{{$ad->name}}">
                        <img src="{{$ad->image}}" alt="{{$ad->name}}" class="img-responsive"/>
                    </a>
                </div>
                @endforeach
            </aside>
        </div>
    </div>

    {{--<div class="container hidden-xs j-partner">--}}
        {{--<div class="panel panel-default">--}}
            {{--<!-- S 合作伙伴 -->--}}
            {{--<div class="panel-heading">--}}
                {{--<h3 class="panel-title">--}}
                    {{--合作伙伴--}}
                    {{--<small>感谢以下的合作伙伴的大力支持</small>--}}
                    {{--<a href="https://wpa.qq.com/msgrd?v=3&uin=&site=&menu=yes" target="_blank" class="more">联系我们</a>--}}
                {{--</h3>--}}
            {{--</div>--}}
            {{--<div class="panel-body">--}}
                {{--<ul class="list-unstyled list-partner">--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/58.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/360.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/alipay.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/baidu.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/boc.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/cctv.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/didi.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/iqiyi.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/qq.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/suning.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/taobao.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/tuniu.png" /></a></li>--}}
                    {{--<li><a href="/"><img src="https://cdn.demo.fastadmin.net/assets/addons/cms/img/logo/weibo.png" /></a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<!-- E 合作伙伴 -->--}}

            {{--<!-- S 友情链接 -->--}}
            {{--<div class="panel-heading">--}}
                {{--<h3 class="panel-title">友情链接--}}
                    {{--<small>申请友情链接请务必先做好本站链接</small>--}}
                    {{--<a href="https://wpa.qq.com/msgrd?v=3&uin=&site=&menu=yes" target="_blank" class="more">申请友链</a></h3>--}}
            {{--</div>--}}
            {{--<div class="panel-body">--}}
                {{--<div class="list-unstyled list-links">--}}
                    {{--<a href="" title="码云 - 码云">码云</a>--}}
                    {{--<a href="https://gitee.com" title="码云">码云</a>--}}
                    {{--<a href="https://github.com" title="码云">码云</a>--}}
                    {{--<a href="" title="码云 - 码云">码云</a>--}}
                    {{--<a href="" title="码云 - 码云">码云</a>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- E 友情链接 -->--}}
        {{--</div>--}}

    {{--</div>--}}
@endsection