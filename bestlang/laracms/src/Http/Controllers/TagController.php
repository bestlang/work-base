<?php

namespace BestLang\LaraCms\Http\Controllers;

use BestLang\LaraCms\Models\Cms\Tag;
use Illuminate\Http\Request;

class TagController extends Controller{

    public function contents($name, Request $request)
    {
        $tag = Tag::where('name', $name)->first();
        $contents = $tag->contents()->with(['metas', 'tags'])->get();
        return render('tag.tag', ['tag' => $tag, 'contents'=> $contents]);
    }
}
