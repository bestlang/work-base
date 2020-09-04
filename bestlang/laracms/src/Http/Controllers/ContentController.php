<?php

namespace Bestlang\Laracms\Http\Controllers;

use Illuminate\Http\Request;
use Bestlang\Laracms\Models\Cms\Content;

class ContentController extends Controller
{
    public function index(Request $request, $id)
    {
        $content = Content::with(['contents', 'metas', 'channel', 'model'])->find($id);
        //获取评论 @TODO 改为异步获取
        $comments = $content->comments;

        $content->ext = $content->getExt();

        $view_path = 'models.'.$content->channel->content_template;
        return render($view_path, compact(['content', 'comments']));
    }
}
