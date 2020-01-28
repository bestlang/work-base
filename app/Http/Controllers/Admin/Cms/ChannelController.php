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
        $name = Arr::get($params, 'name', '');
        if($parent_id){
            $data = Arr::only($params, ['name', 'title', 'keywords', 'description', 'model_id']);
            $parent = Channel::find($parent_id);
            //check if parent channel has sub-channel with the same name
            $has = $parent->getDescendants(1)->contains(function($item)use($name){return $item->name == $name;});
            if($has){
                return response()->error('添加失败!父栏目包含同名子栏目');
            }
            if($parent){
                $child = Channel::create($data);
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

    public function delete(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return response()->error('参数错误');
        }
        try{
            $model = Channel::where('id', $id)->firstOrFail();
            $childrenCount = $model->getDescendants()->count();
            if($childrenCount>0){
                return response()->error('栏目包含子栏目,无法删除!');
            }
            if($model->contents->count()>0){
                return response()->error('栏目包含内容,无法删除!');
            }
            $model->delete();
            return response()->ajax();
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->error('模型不存在');
        }
        return response()->error('未知错误');
    }
}
