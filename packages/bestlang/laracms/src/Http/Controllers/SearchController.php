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
            $ext = [];
            foreach ($content->metas as $meta){
                $ext[$meta->field] = json_decode($meta->value) ? json_decode($meta->value) : $meta->value;
            }
            $content->ext = $ext;
        });
        return view('laracms::dark.search.search', ['keyword' => $keyword, 'contents'=> $contents]);
    }
}
