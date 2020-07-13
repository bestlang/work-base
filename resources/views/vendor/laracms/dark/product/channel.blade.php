@extends('laracms::dark.layouts.app')
@section('content')
    <div class="">
        <div class="">
            <div class="container">
                <h1 class="category-title">
                    {{$channel->name}}
                    <div class="more pull-right">
                        <ol class="breadcrumb">
                            @foreach(LC::breadcrumbs($channel) as $b)
                                <li><a href="{{$b->url}}">{{$b->name}}</a></li>
                            @endforeach
                        </ol>
                    </div>
                </h1>
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            @if(count($contents))
                                    <div class="row" style="padding: 0 15px;">
                                        @foreach($contents as $content)
                                            <div class="col-sm-4" style="padding: 5px;">
                                                <div style="box-sizing: border-box;border: 1px solid #f5f5f5;padding: 5px;">
                                                    <a href="{{route('content', $content->id)}}">
                                                    @if(isset($content->ext['thumb']) && $thumb = $content->ext['thumb'])
                                                        <img src="{{$thumb}}" alt="{{$content->title}}" style="width: 100%;" />
                                                    @endif
                                                    <div><b>{{$content->title}}</b></div>
                                                    <div>价格: ¥{{$content->ext['price']}}</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" style="padding: 5px;">
                                                <div style="box-sizing: border-box;border: 1px solid #f5f5f5;padding: 5px;">
                                                    <a href="{{route('content', $content->id)}}">
                                                        @if(isset($content->ext['thumb']) && $thumb = $content->ext['thumb'])
                                                            <img src="{{$thumb}}" alt="{{$content->title}}" style="width: 100%;" />
                                                        @endif
                                                        <div><b>{{$content->title}}</b></div>
                                                        <div>价格: ¥{{$content->ext['price']}}</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-4" style="padding: 5px;">
                                                <div style="box-sizing: border-box;border: 1px solid #f5f5f5;padding: 5px;">
                                                    <a href="{{route('content', $content->id)}}">
                                                        @if(isset($content->ext['thumb']) && $thumb = $content->ext['thumb'])
                                                            <img src="{{$thumb}}" alt="{{$content->title}}" style="width: 100%;" />
                                                        @endif
                                                        <div><b>{{$content->title}}</b></div>
                                                        <div>价格: ¥{{$content->ext['price']}}</div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{--<article class="article-item" style="padding: 20px 0;border-bottom: 1px solid #efefef;">--}}
                                            {{--<div class="media">--}}
                                                {{--<div class="media-left">--}}
                                                    {{--<a href="{{route('content', $content->id)}}" style="width: 160px;display: block;">--}}
                                                        {{--<div class="embed-responsive embed-responsive-4by3 img-zoom">--}}
                                                            {{--@if(isset($content->ext['thumb']) && $thumb = $content->ext['thumb'])--}}
                                                                {{--<img src="{{$thumb}}" alt="{{$content->title}}"  />--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                                {{--<div class="media-body" style="position: relative;">--}}
                                                    {{--<h3 class="article-title" style="margin: 0;font-size: 1.25em;">--}}
                                                        {{--<a href="{{route('content', $content->id)}}">{{$content->title}}</a>--}}
                                                    {{--</h3>--}}
                                                    {{--<div class="article-intro hidden-xs" style="line-height: 22px;">--}}
                                                        {{--{{$content->description}}--}}
                                                    {{--</div>--}}
                                                    {{--<div class="articlee-tag">--}}
                                                        {{--@foreach($content->tags as $tag)--}}
                                                            {{--<a href="{{route('tag', $tag->name)}}" class="tag tag-primary">{{$tag->name}}</a>--}}
                                                        {{--@endforeach--}}
                                                    {{--</div>--}}
                                                    {{--<div style="position: absolute;bottom: 0;">--}}

                                                        {{--<span itemprop="date">{{LC::dateFormat($content->created_at)}}</span>--}}
                                                        {{--<span itemprop="likes" title="点赞次数"><i class="fa fa-thumbs-up"></i> 0 点赞</span>--}}
                                                        {{--<span itemprop="comments"><a href="{{route('content', $content->id)}}#comments" target="_blank" title="评论数"><i class="fa fa-comments"></i> {{$content->comments()->count()}}</a> 评论</span>--}}
                                                        {{--<span itemprop="views" title="浏览次数"><i class="fa fa-eye"></i> 7074 浏览</span>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</article>--}}
                                </div>
                            @else
                                <section class="text-center">无记录</section>
                            @endif
                                <div class="text-center pager"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">文章推荐</h3></div>
                            <div class="panel-body">
                                @foreach(LC::position('文章详情右侧推荐一') as $key => $content)
                                    <div class="media">
                                        {{--@if($thumb = $content->ext['thumb'])--}}
                                        {{--<div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>--}}
                                        {{--@endif--}}
                                        <div class="media-left">{{$key+1}}</div>
                                        <div class="media-body">
                                            <div><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></div>
                                            {{--<p>{{$content->created_at}}</p>--}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{----}}
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">文章推荐</h3></div>
                            <div class="panel-body">
                                @foreach(LC::position('文章详情右侧推荐一') as $key => $content)
                                    <div class="media">
                                        {{--@if($thumb = $content->ext['thumb'])--}}
                                        {{--<div><img src="{{$thumb}}" alt="" style="width: 100px;height: 100px;"></div>--}}
                                        {{--@endif--}}
                                        <div class="media-left">{{$key+1}}</div>
                                        <div class="media-body">
                                            <div><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></div>
                                            {{--<p>{{$content->created_at}}</p>--}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
