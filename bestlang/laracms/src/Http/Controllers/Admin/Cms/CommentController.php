<?php
namespace BestLang\LaraCms\Http\Controllers\Admin\Cms;

use BestLang\LaraCms\Models\Cms\Content;
use Illuminate\Http\Request;
use BestLang\LaraCms\Http\Controllers\Controller;
use BestLang\LaraCms\Models\Cms\Comment;

class CommentController extends Controller{

    public function index(Request $request){
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);
        $query = Comment::query();
        $query = $query->whereHas('ref');
        $total = $query->count();
        $comments = $query->with(['ref.channel', 'user'])->limit($pageSize)->offset(($page - 1 ) * $pageSize)->get();
        $comments->map(function($comment){
            if($comment->ref){
                $comment->ref->link = route('content', $comment->ref->id);
            }
        });
        return response()->ajax(['total' => $total, 'comments' => $comments]);
    }

    public function content(Request $request)
    {
        $content_id = $request->input('content_id', 0);
        try {
            $content = Content::where('id', $content_id)->with(['comments', 'channel'])->firstOrFail();
            $content->link = route('content', $content_id);
            return response()->ajax($content);
        }catch (\Exception $e){
            return response()->ajax([]);
        }
    }
}