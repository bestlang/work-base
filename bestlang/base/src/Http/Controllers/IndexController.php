<?php
namespace BestLang\Base\Http\Controllers;

class IndexController extends Controller
{
    public function csrf()
    {
        return response()->ajax(csrf_token());
    }

    public function user()
    {
        return response()->ajax(['user' => auth()->user(), 'csrf' => csrf_token()]);
    }
}