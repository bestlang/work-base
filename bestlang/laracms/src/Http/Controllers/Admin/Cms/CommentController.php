<?php
namespace BestLang\LaraCms\Http\Controllers\Admin\Cms;

use BestLang\LaraCms\Models\Cms\Content;
use Illuminate\Http\Request;
use BestLang\LaraCms\Http\Controllers\Controller;
use BestLang\LaraCms\Models\Cms\Comment;

class CommentController extends Controller{

    public function index(Request $request){
        $per_page = $request->input('per_page', 10);
        $comments = Comment::with(['ref','ref.channel', 'user'])->paginate($per_page);
        $comments->map(function($comment){
            if($comment->ref){
                $comment->ref->link = route('content', $comment->ref->id);
            }
        });
        return response()->ajax($comments);
    }

    public function content(Request $request)
    {
        $content_id = $request->input('content_id', 0);
        $content = Content::where('id', $content_id)->with(['comments','channel'])->firstOrFail();
        $content->link = route('content', $content_id);
        return response()->ajax($content);
    }
}