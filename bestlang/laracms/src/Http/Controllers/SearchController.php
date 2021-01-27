<?php

namespace BestLang\LaraCMS\Http\Controllers;

use BestLang\LaraCMS\Models\CMS\Content;
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
