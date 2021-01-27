<?php

namespace BestLang\LaraCMS\Http\Controllers;

use BestLang\LaraCMS\Models\CMS\Tag;
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
