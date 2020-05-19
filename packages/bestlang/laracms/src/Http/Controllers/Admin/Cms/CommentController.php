<?php
namespace Bestlang\Laracms\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use Bestlang\Laracms\Http\Controllers\Controller;
use Bestlang\Laracms\Models\Cms\Comment;

class CommentController extends Controller{

    public function index(Request $request){
        $comments = Comment::with('ref')->get();
        return response()->ajax($comments);
    }
}