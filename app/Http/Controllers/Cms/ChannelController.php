<?php

namespace App\Http\Controllers\Cms;

use App\Models\Cms\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function index(Request $request, $id)
    {
        $channel = Channel::with('contents')->findOrFail($id);
        $contents = $channel->contents()->paginate(20);
//        print_r($contents);
        return view('cms.'.config('cms.theme').'.channel.channel', compact(['channel', 'contents']));
    }
}
