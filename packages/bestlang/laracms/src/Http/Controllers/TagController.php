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
            $ext = [];
            foreach ($content->metas as $meta){
                $ext[$meta->field] = json_decode($meta->value) ? json_decode($meta->value) : $meta->value;
            }
            $content->ext = $ext;
        });
        return view('laracms::dark.tag.tag', ['tag' => $tag, 'contents'=> $contents]);
    }
}
