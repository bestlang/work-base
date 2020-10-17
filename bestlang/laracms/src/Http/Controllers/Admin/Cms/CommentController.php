<?php
namespace BestLang\Laracms\Http\Controllers\Admin\Cms;

use BestLang\Laracms\Models\Cms\Content;
use Illuminate\Http\Request;
use BestLang\Laracms\Http\Controllers\Controller;
use BestLang\Laracms\Models\Cms\Comment;

class CommentController extends Controller{

    public function index(Request $request){
        $per_page = $request->input('per_page', 10);
        $comments = Comment::with(['ref','ref.channel', 'user'])->paginate($per_page);
        $comments->map(function($comment){
            $comment->ref->link = route('content', $comment->ref->id);
        });
        return response()->ajax($comments);
    }

    public function content(Request $request)
    {
        $content_id = $request->input('content_id', 0);
        $content = Content::where('id', $content_id)->with(['comments','channel'])->first();
        $content->link = route('content', $content_id);
        return response()->ajax($content);
    }
}