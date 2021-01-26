<?php

namespace BestLang\LaraCMS\Http\Controllers;

use BestLang\LaraCMS\Models\User;
use Illuminate\Http\Request;
use BestLang\LaraCMS\Models\Cms\Content;
use Arr;

class ContentController extends Controller
{
    public function index(Request $request, $id)
    {
        //可能会出现模板没有配置的情况，这时候render函数抛出异常
        try{
            $content = Content::with(['contents', 'metas', 'channel', 'model'])->findOrFail($id);
            $view_path = 'models.'.$content->channel->content_template;
            return render($view_path, compact(['content']));
        }catch (\Exception $e){
            return $e->getMessage();//redirect(route('404'));
        }
    }

    //文章阅读数增加
    public function view(Request $request)
    {
        $content_id = $request->input('content_id');
        $content = Content::find($content_id);
        if($content){
            try{
                $content->increment('views');
            }catch (\Exception $e){
                $content->views = 1;
                $content->save();
            }
            return response()->ajax();
        }
        return response()->error('出错了');
    }
    //喜欢
    public function like(Request $request)
    {
        $params = $request->all();
        $content_id = Arr::get($params, 'content_id', 0);
        $user = auth()->user();
        $user = User::find($user->id);
        $user->likes()->attach([$content_id]);
        return response()->ajax();
    }
    //取消喜欢
    public function unlike(Request $request)
    {
        $params = $request->all();
        $content_id = Arr::get($params, 'content_id', 0);
        $user = auth()->user();
        $user = User::find($user->id);
        $user->likes()->detach([$content_id]);
        return response()->ajax();
    }
}
