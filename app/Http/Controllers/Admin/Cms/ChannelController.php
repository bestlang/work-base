<?php

namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\Channel;
use Illuminate\Support\Arr;

class ChannelController extends Controller
{
    public function tree(Request $request)
    {
        $params = $request->all();
        $disabled = Arr::get($params, 'disabled', false);
        $tree = Channel::all()->map(function($item)use($disabled){
            if($disabled){
                $item->disabled=true;
            }
            return $item;
        })->toHierarchy();
        return response()->ajax($tree);
    }

    public function add(Request $request)
    {
        $params = $request->all();
        $parent_id = Arr::get($params, 'parent_id', 0);
        $name = Arr::get($params, 'name', 0);
        if($parent_id){
            $parent = Channel::find($parent_id);
            if($parent){
                $child = Channel::create(['name' => $name]);
                $child->makeChildOf($parent);
                return response()->ajax($child);
            }
        }
        return response()->ajax();
    }
}
