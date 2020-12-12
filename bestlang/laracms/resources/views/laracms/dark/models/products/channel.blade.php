@extends('laracms::dark.layouts.app')
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
                            @foreach(laracms::breadcrumbs($channel) as $b)
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
                                                    @if($content->thumb)
                                                        <img src="{{$content->thumb}}" alt="{{$content->title}}" style="width: 100%;" />
                                                    @endif
                                                    <div><b>{{$content->title}}</b></div>
                                                    <div>价格: ¥{{$content->price}}</div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
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
                                @foreach(laracms::position('文章详情右侧推荐一') as $key => $content)
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
