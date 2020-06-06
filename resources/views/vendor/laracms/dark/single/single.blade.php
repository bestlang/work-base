@extends('laracms::dark.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>{{$channel->title}}</h3></div>
                    <div class="panel-body">
                        {!! $channel->ext['content'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
