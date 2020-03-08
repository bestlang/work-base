<?php

namespace Bestlang\Laracms\Http\Controllers;

use Bestlang\Laracms\Models\Cms\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index(Request $request, $id)
    {
        $channel = Channel::with('contents')->findOrFail($id);
        $contents = $channel->contents()->paginate(20);
        return view('laracms::dark.channel.channel', compact(['content', 'channel']));
    }
}
