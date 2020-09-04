<?php

namespace Bestlang\Laracms\Http\Controllers;

use Bestlang\Laracms\Models\Cms\Tag;
use Illuminate\Http\Request;

class TagController extends Controller{

    public function contents($name, Request $request)
    {
        $tag = Tag::where('name', $name)->first();
        $contents = $tag->contents()->with(['metas', 'tags'])->get();
        $contents->map(function($content){
            $content->ext = $content->getExt();
        });
        return render('tag.tag', ['tag' => $tag, 'contents'=> $contents]);
    }
}
