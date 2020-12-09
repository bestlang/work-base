<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>本月迟到提醒</title>
</head>
<body>
<h4>亲爱的 <span style="border-bottom: 1px solid #2d2d2d;padding: 0 30px;display: inline-block">{{$user->name}}</span>同学:</h4>
<p>截止到昨日，本月你已经迟到 <span style="color: red">{{$user->ct}}</span>次。</p>
<p>请注意合理安排上班时间，以免影响绩效考核。</p>
<div style="width: 100%;border-bottom: 1px dotted #ccc"></div>
<p><i>本邮件由后台程序自动发送，请勿回复。</i></p>
</body>
</html>