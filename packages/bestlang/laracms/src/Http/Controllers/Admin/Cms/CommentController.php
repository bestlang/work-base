<?php
namespace Bestlang\Laracms\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use Bestlang\Laracms\Http\Controllers\Controller;
use Bestlang\Laracms\Models\Cms\Comment;

class CommentController extends Controller{

    public function index(Request $request){
        $per_page = $request->input('per_page', 10);
        $comments = Comment::with(['ref','ref.channel'])->paginate($per_page);
        $comments->map(function($comment){
            $comment->ref->link = route('content', $comment->ref->id);
        });
        return response()->ajax($comments);
    }
}