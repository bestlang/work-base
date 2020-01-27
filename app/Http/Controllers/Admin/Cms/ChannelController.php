<?php

namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\Channel;
use Illuminate\Support\Arr;
use Validator;

class ChannelController extends Controller
{
    // get channels in tree format
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
    // get direct children channel
    public function children(Request $request)
    {
        $parent_id = $request->input('parent_id', 0);
        $children = Channel::where('parent_id', $parent_id)->get();
        return response()->ajax($children);
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
        }else{
            if($name){
                $channel = Channel::create(['name' => $name]);
            }
        }
        return response()->ajax();
    }

    public function update(Request $request)
    {
        $params = $request->all();
        $rules = [
            'id' => 'required',
            'name' => 'required',
        ];
        $names = [
            'id' => 'ID',
            'name' => '栏目名'
        ];
        $validator = Validator::make($params, $rules, [], $names);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $id = Arr::get($params, 'id', 0);
        $updated = Arr::only($params, ['name', 'title', 'keywords', 'description', 'model_id']);
        $channel = Channel::find($id);
        $channel->update($updated);
        return response()->ajax();
    }
}
