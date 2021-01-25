<?php
namespace BestLang\Base\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        $defaultModule = env('DEFAULT_MODULE', 'LaraCMS');
        $lowCaseName = strtolower($defaultModule);
        $m = app()->make($lowCaseName);
        return $m->homePage();
    }

    public function csrf()
    {
        return response()->ajax(csrf_token());
    }

    public function user()
    {
        return response()->ajax(['user' => auth()->user(), 'csrf' => csrf_token()]);
    }
}