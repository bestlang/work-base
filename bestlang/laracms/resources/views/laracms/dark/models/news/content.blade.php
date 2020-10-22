@extends('laracms::dark.layouts.app')

@section('content')
    <link rel="stylesheet"
          href="https://highlightjs.org/static/demo/styles/railscasts.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.3.1/highlight.min.js"></script>
    <div class="l-content">
            <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default article-content">
                        <div class="panel-heading">
                            <ol class="breadcrumb">
                                @foreach(laracms::breadcrumbs($content->channel) as $b)
                                <li><a href="{{$b->url}}">{{$b->name}}</a></li>
                                @endforeach
                                <li>正文</li>
                            </ol>
                        </div>
                        <div class="l-article-body">
                            <pre><code>
function $initHighlight(block, cls) {
  try {
    if (cls.search(/\bno\-highlight\b/) != -1)
      return process(block, true, 0x0F) +
             ` class="${cls}"`;
  } catch (e) {
    /* handle exception */
  }
  for (var i = 0 / 2; i < classes.length; i++) {
    if (checkCondition(classes[i]) === undefined)
      console.log('undefined');
  }
}
export  $initHighlight;
</code></pre>
                            <h1 class="l-content-title">{{$content->title}}</h1>
                            <div>{!!  laracms::content($content, 'content') !!}</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" id="comments">
                            <h3 class="panel-title">评论列表</h3>
                        </div>
                        <div class="panel-body">
                            <div>
                                @foreach($comments as $comment)
                                    <p>{{$comment->user ? $comment->user->name: ''}} says:{{$comment->content}}</p>
                                @endforeach
                            </div>
                            @guest
                            @if(Route::has('login'))
                                <a href="{{ route('login') }}" class="l-a">登录</a>之后发表评论
                            @endif
                            @endguest
                            @auth
                            <form>
                                <div class="form-group">
                                    <label for="comment">评论:</label>
                                    <input type="hidden" name="content_id" id="content_id" value="{{$content->id}}" />
                                    <textarea class="form-control" rows="5" id="comment" style="resize: none;"></textarea>
                                    <button type="button" class="btn btn-primary" id="comment_submit">提交</button>
                                </div>
                            </form>
                            @endauth
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
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">文章推荐</h3></div>
                        <div class="panel-body">
                            @foreach(laracms::position('文章详情右侧推荐一') as $key => $content)
                                <div class="media">
                                    <div class="media-left">{{$key+1}}</div>
                                    <div class="media-body">
                                        <div><a target="_self" href="{{route('content', $content->id)}}">{{$content->title}}</a></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            </div>

    </div>
@endsection
@push('script')
<script type="text/javascript">
    $(function(){
        hljs.initHighlightingOnLoad()
        $('#comment_submit').click(function(){
            const content = $('#comment').val();
            const contend_id = $('#content_id').val();

            axios.post('/comment/save', {content: content, content_id:contend_id}).then(response => {
                let res = response.data;
                if(res.success){
                    alert('评论成功')
                    location.reload()
                }else{
                    alert(JSON.stringify(res.error))
                }
            })
        });
    });
</script>
@endpush
@push('css')
<style>
    #comment_submit{
        margin-top: 10px;
    }
</style>
@endpush