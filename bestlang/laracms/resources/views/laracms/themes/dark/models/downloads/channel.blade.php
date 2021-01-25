@extends('LaraCMS::themes.dark.layouts.app')
@section('title')
    {{$channel->name}}
@endsection
@section('content')
    <div class="">
        <div class="">
            <div class="container">
                <h1 class="category-title">
                    {{$channel->name}}
                    <div class="more pull-right">
                        <ol class="breadcrumb">
                            @foreach(LaraCMS::breadcrumbs($channel) as $b)
                                <li><a href="{{$b->url}}">{{$b->name}}</a></li>
                            @endforeach
                        </ol>
                    </div>
                </h1>
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <span>列表</span>
                                </h3>
                            </div>
                            <div class="panel-body article-list">
                            @if(count($contents))
                                @foreach($contents as $content)
                                    <article class="article-item" style="padding: 20px 0;border-bottom: 1px solid #efefef;">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="{{route('content', $content->id)}}" style="width: 160px;display: block;">
                                                    <div class="embed-responsive embed-responsive-4by3 img-zoom">
                                                        @if($content->thumb)
                                                            <img src="{{$content->thumb}}" alt="{{$content->title}}"  />
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="media-body" style="position: relative;">
                                                <h3 class="article-title" style="margin: 0;font-size: 1.25em;">
                                                    <a href="{{route('content', $content->id)}}">{{$content->title}}</a>
                                                </h3>
                                                <div class="article-intro hidden-xs" style="line-height: 22px;">
                                                    {{$content->description}}
                                                </div>
                                                <div class="article-tag">
                                                    @foreach($content->tags as $tag)
                                                        <a href="{{route('tag', $tag->name)}}" class="tag tag-primary">{{$tag->name}}</a>
                                                    @endforeach
                                                </div>
                                                <div style="position: absolute;bottom: 0;">

                                                    <span itemprop="date">{{LaraCMS::dateFormat($content->created_at)}}</span>
                                                    <span itemprop="likes" title="点赞次数"><i class="fa fa-thumbs-up"></i> 0 点赞</span>
                                                    <span itemprop="comments"><a href="{{route('content', $content->id)}}#comments" target="_blank" title="评论数"><i class="fa fa-comments"></i> {{$content->comments()->count()}}</a> 评论</span>
                                                    <span itemprop="views" title="浏览次数"><i class="fa fa-eye"></i> 7074 浏览</span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
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
                                @foreach(LaraCMS::position('文章详情右侧推荐一') as $key => $content)
                                    <div class="media">
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
