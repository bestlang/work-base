<?php

namespace BestLang\LaraCMS\Http\Controllers;

use Illuminate\Http\Request;
use BestLang\LaraCMS\Models\Cms\Content;

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
}
