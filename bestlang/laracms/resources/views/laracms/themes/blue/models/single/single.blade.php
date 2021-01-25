@extends('LaraCMS::themes.blue.layouts.app')
@section('title')
    {{$channel->name}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>{{$channel->title}}</h3></div>
                    <div class="panel-body">
                        @if($channel->content)
                            {!! $channel->content !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
