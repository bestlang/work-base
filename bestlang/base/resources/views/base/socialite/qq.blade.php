@extends('base::layouts.app')


@section('title')
    QQ
@endsection

@section('content')
@endsection
@push('script')
<script>
    $(function(){
        axios.get('/ajax/user').then(response => {
            var res = response.data
            if(res.success){
                var user = res.data.user
                var name = user.name
                var type = user.type
                var token = res.data.csrf
                localStorage.setItem('name', name)
                localStorage.setItem('type', type)
                localStorage.setItem('token', token)
                location.href = '/';
            }else{
                alert(Object.values(res.error).join(''))
            }
        })
    })
</script>
@endpush
