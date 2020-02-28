<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function index()
    {
        return view('cms.'.config('cms.theme').'.index.index');
    }

    public function cms()
    {
        // 获取首页推荐的栏目
        // 取得栏目里面的文章
        return view('cms.'.config('cms.theme').'.index.cms');
    }

    public function about()
    {
        return view('cms.'.config('cms.theme').'.index.about');
    }

    public function contact()
    {
        return view('cms.'.config('cms.theme').'.index.contact');
    }
}
