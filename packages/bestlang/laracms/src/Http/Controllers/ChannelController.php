<?php

namespace Bestlang\Laracms\Http\Controllers;

use App\Models\Cms\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function index(Request $request, $id)
    {
        $channel = Channel::with('contents')->findOrFail($id);
        $contents = $channel->contents()->paginate(20);
        dd($contents);return;
        //return view('cms.'.config('cms.theme').'.channel.channel', compact(['channel', 'contents']));
    }
}
