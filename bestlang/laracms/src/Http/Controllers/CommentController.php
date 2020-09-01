<?php

namespace Bestlang\Laracms\Http\Controllers;

use Bestlang\Laracms\Models\Cms\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Arr;

class CommentController extends Controller
{
    public function save(Request $request)
    {
        $params = $request->validate([
            'content_id' => 'required|numeric',
            'content' => 'required',
            'parent_id' => 'nullable|numeric'
        ]);
        $user = auth()->user();
        $comment = new Comment();
        $comment->user_id = $user->id;

        $parent_id = Arr::get($params, 'parent_id', 0);
        if($parent_id){
            $comment->parent_id = $parent_id;
        }
        $comment->content_id = $params['content_id'];
        $comment->content = $params['content'];
        $comment->save();
        return response()->ajax([]);
    }
}
