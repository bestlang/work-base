@extends('LaraCMS::themes.blue.layouts.app')
@section('content')
    <div style="margin: 50px auto;text-align: center">
        <div>打开微信扫一扫完成付款</div>
        <img src="" alt="" id="native1_code" style="width: 200px;height: 200px;margin: 10px auto 0;">
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        var order_no = "{{$order_no}}"
        $(function(){
            axios.post('/ajax/pay/native1', {order_no}).then(response => {
                let res = response.data;
                if(res.success){
                    $('#native1_code').attr('src', res.data)
                }else{
                    if(res.code == 401){
                        alert(res.error);
                        top.location.href = '/login';
                    }
                }
            })
        })
    </script>
@endpush