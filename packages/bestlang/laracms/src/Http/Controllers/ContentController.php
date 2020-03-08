<?php

namespace Bestlang\Laracms\Http\Controllers;

use Illuminate\Http\Request;
use Bestlang\Laracms\Models\Cms\Content;

class ContentController extends Controller
{
    public function index(Request $request, $id)
    {
        $content = Content::with(['contents', 'metas', 'channel', 'model'])->find($id);
        //获取评论
        $comments = $content->comments;
//        print_r($comments->toArray());
        //在这里判断渲染哪个模板
//        print_r(json_encode($content, JSON_UNESCAPED_UNICODE));return;
        $content_template_prefix = $content->model->content_template_prefix;
        $content_template = $content->channel->content_template;
        return view('laracms::dark.content.'.$content_template_prefix.'.'.$content_template, compact(['content', 'comments']));
    }
}
