<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$notice->title}}</title>
</head>
<body>
    {{--<h4>亲爱的 <span style="border-bottom: 1px solid #2d2d2d;padding: 0 30px;display: inline-block">{{$user->name}}</span>同学:</h4>--}}
    <div>
        {{$notice->content}}
    </div>
    <div style="width: 100%;border-bottom: 1px dotted #ccc"></div>
    <p><i>本邮件由后台程序自动发送，请勿回
            复。</i></p>
</body>
</html>