<?php

namespace BestLang\LaraCms\Http\Controllers;

use BestLang\LaraCms\Models\Cms\Tag;
use Illuminate\Http\Request;

class TagController extends Controller{

    public function contents($name, Request $request)
    {
        try {
            $tag = Tag::where('name', $name)->firstOrFail();
            $contents = $tag->contents()->with(['metas', 'tags'])->get();
        }catch (\Exception $e){
            return redirect(route('404'));
        }
        return render('tag.tag', ['tag' => $tag, 'contents'=> $contents]);
    }
}
