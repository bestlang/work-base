<?php

namespace Bestlang\Laracms\Http\Controllers;

use Bestlang\Laracms\Models\Cms\Channel;
use Bestlang\Laracms\Models\Cms\Content;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index(Request $request, $id)
    {
        $channel = Channel::with('contents')->findOrFail($id);
//        $contents = $channel->contents()->with(['metas', 'contents'])->paginate(20);
        $channelIds = $channel->descendantsAndSelf()->get()->map(function($item){return $item->id;} )->toArray();
        $contents = Content::whereIn('channel_id', $channelIds)->with(['metas', 'contents'])->paginate(20);
        $contents->map(function($content){
            $ext = [];
            foreach ($content->metas as $meta){
                $ext[$meta->field] = $meta->value;
            }
            $content->ext = $ext;
        });
        return view('laracms::dark.channel.channel', compact(['contents', 'channel']));
    }

    public function single(Request $request, $id)
    {
        $channel = Channel::with('metas')->findOrFail($id);
        $ext = [];
        foreach ($channel->metas as $meta){
            $ext[$meta->field] = $meta->value;
        }
        $channel->ext = $ext;
        return view('laracms::dark.single.single', compact('channel'));
    }
}
