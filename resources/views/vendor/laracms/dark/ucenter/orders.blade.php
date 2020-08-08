@extends('laracms::dark.layouts.ucenter')
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="page-header">
                订单记录
            </h2>
            <div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>产品名</th>
                        <th>订单号</th>
                        <th>订单金额</th>
                        <th>订单状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->name}}</td>
                        <td>{{$order->order_no}}</td>
                        <td>{{$order->money}}</td>
                        <td>{{$order->status_text}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(function(){
            $('.l-menu-order').addClass('active')
        })
    </script>
@endsection