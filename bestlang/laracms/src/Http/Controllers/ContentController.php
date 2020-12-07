<?php

namespace BestLang\LaraCms\Http\Controllers;

use Illuminate\Http\Request;
use BestLang\LaraCms\Models\Cms\Content;

class ContentController extends Controller
{
    public function index(Request $request, $id)
    {
        //可能会出现模板没有配置的情况，这时候render函数抛出异常
        try{
            $content = Content::with(['contents', 'metas', 'channel', 'model'])->findOrFail($id);

            //获取评论 @TODO 改为异步获取
            $comments = $content->comments;


            $view_path = 'models.'.$content->channel->content_template;
            return render($view_path, compact(['content', 'comments']));
        }catch (\Exception $e){
            return redirect(route('404'));
        }
    }
}
