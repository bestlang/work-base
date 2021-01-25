<?php

namespace BestLang\LaraCMS\Http\Controllers;

use Illuminate\Http\Request;
use Arr;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $params = $request->all();
        $content_id = Arr::get($params, 'content_id', 0);
        $user = auth()->user();
        $user->likes()->attach([$content_id]);
    }

    public function unlike(Request $request)
    {
        $params = $request->all();
        $content_id = Arr::get($params, 'content_id', 0);
        $user = auth()->user();
        $user->likes()->detach([$content_id]);
    }
}
