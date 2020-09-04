<?php

namespace Bestlang\Laracms\Http\Controllers;

use Bestlang\Laracms\Models\Cms\Content;
use Illuminate\Http\Request;

class SearchController extends Controller{

    public function contents($keyword, Request $request)
    {
        $contents = Content::query()
            ->where('title','like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orWhere('keywords', 'like', "%{$keyword}%")
            ->with(['metas', 'tags'])->get();
        $contents->map(function($content){
            $content->ext = $content->getExt();
        });
        return render('search.search', ['keyword' => $keyword, 'contents'=> $contents]);
    }
}
