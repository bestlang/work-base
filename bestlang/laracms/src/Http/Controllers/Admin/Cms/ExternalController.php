<?php
namespace BestLang\Laracms\Http\Controllers\Admin\Cms;

use BestLang\Laracms\Http\Controllers\Controller;
use BestLang\Laracms\Services\ContentService;
use Illuminate\Http\Request;

class ExternalController extends Controller
{
    //分页获取文章
    public function contents(Request $request)
    {
        $channelId = $request->input('channel_id', 0);
        $page = $request->input('page', 0);
        $keyword = $request->input('keyword', null);
        $pageSize = $request->input('page_size', 10);
        $res = ContentService::contents($channelId, $page, $pageSize, $keyword);
        return response()->ajax($res);
    }
    //单篇文章
    public function content(Request $request)
    {
        $contentId = $request->input('content_id', 0);
        $content = ContentService::content($contentId);
        return response()->ajax($content);
    }
}