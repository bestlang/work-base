<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\Content;

class ContentController extends Controller
{
    public function index(Request $request, $id)
    {
        $content = Content::with(['contents', 'metas'])->find($id);
        //获取评论
        $comments = $content->comments;
//        print_r($comments->toArray());
        //在这里判断渲染哪个模板
//        print_r(json_encode($content, JSON_UNESCAPED_UNICODE));return;
        return view('cms.'.config('cms.theme').'.content.content', compact(['content', 'comments']));
    }
}
