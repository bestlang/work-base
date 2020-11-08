<?php

namespace BestLang\LaraCms\Http\Controllers;

use BestLang\LaraCms\Models\Cms\Content;
use Illuminate\Http\Request;

class SearchController extends Controller{

    public function contents($keyword, Request $request)
    {
        $contents = Content::query()
            ->where('title','like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orWhere('keywords', 'like', "%{$keyword}%")
            ->with(['metas', 'tags'])->get();
        return render('search.search', ['keyword' => $keyword, 'contents'=> $contents]);
    }
}
