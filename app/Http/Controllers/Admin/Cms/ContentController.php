<?php

namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\Content;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $channelId = $request->input('channelId', 0);
        if(!$channelId){
            return response()->error('参数错误');
        }else{
            return response()->ajax([]);
        }
    }
}
