<?php
namespace BestLang\Base\Http\Controllers;
use BestLang\Base\Models\Module;

class IndexController extends Controller
{
    public function index()
    {
        $defaultModule = Module::where('is_default', 1)->first();
        if(!$defaultModule){
            $defaultModule = Module::where('type', 1)->first();
        }
        return redirect($defaultModule->uri);
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