<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$notice->title}}</title>
</head>
<body>
    <div>
        {!! $notice->content !!}
    </div>
    <div style="width: 100%;border-bottom: 1px dotted #ccc"></div>
    <p><small><i>本邮件由后台程序自动发送，请勿回复。</i></small></p>
</body>
</html>