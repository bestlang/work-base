<?php

namespace BestLang\LaraCMS\Http\Controllers;

use BestLang\LaraCMS\Models\CMS\Channel;
use BestLang\LaraCMS\Models\CMS\Content;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index(Request $request, $id)
    {
        $channel = Channel::with('contents')->findOrFail($id);
        $channelIds = $channel->descendantsAndSelf()->get()->map(function($item){return $item->id;} )->toArray();
        $contents = Content::whereIn('channel_id', $channelIds)->with(['metas', 'contents'])->paginate(5);
        $view_path = 'models.'.$channel->template;
        return render($view_path, compact(['contents', 'channel']));
    }

    public function single(Request $request, $id)
    {
        $channel = Channel::with('metas')->findOrFail($id);
        $view_path = 'models.'.$channel->template;
        return render($view_path, compact('channel'));
    }
}
