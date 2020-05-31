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

        $ext = [];
        foreach ($content->metas as $meta){
            $ext[$meta->field] = json_decode($meta->value) ? json_decode($meta->value) : $meta->value;
        }
        $content->ext = $ext;

        $content_template_prefix = $content->model->content_template_prefix;
        $content_template = $content->channel->content_template;

        return view('laracms::dark.content.'.$content_template_prefix.'.'.$content_template, compact(['content', 'comments']));
    }
}
