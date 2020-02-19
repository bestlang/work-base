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
        //在这里判断渲染哪个模板
        return view('cms.'.config('cms.theme').'.content.index', compact('content'));
    }
}
