<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\Content;
use App\Models\Cms\Model;
use Arr;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $channelId = $request->input('channel_id', 0);
        $channelId = intval($channelId);
        if(!$channelId){
            $contents = Content::with('channel')->orderBy('id', 'desc')->get();
            return response()->ajax($contents);
        }else{
            $channelIdArr = [];
            $childrenIdArr = Channel::find($channelId)->getDescendants()->map(function($item){return $item->id;})->toArray();
            if(count($childrenIdArr)){
                array_push($channelIdArr, ...$childrenIdArr);
            }
            array_push($channelIdArr, $channelId);
            $contents = Content::whereIn('channel_id', $channelIdArr)->with('channel')->orderByRaw("case when `channel_id`=$channelId then 1 end desc")->orderBy('id', 'desc')->get();
            return response()->ajax($contents);
        }
    }

    public function save(Request $request)
    {
        $params = $request->all();
        $rules = [
            'channel_id' => 'required',
            'model_id' => 'required',
        ];
        $channelId = Arr::get($params, 'channel_id', 0);
        $model_id = Arr::get($params, 'model_id', 0);

        $channel = Channel::find($channelId);
        $model = Model::find($model_id);


        $contentFileds = $model->fields->filter(function($item){return $item->type == 'content';})->map(function($item){ return $item->field;})->toArray();
        $metaFileds = $model->fields->filter(function($item){return $item->is_custom == 1;})->map(function($item){ return $item->field;})->toArray();
        $arr = Arr::only($params, ['channel_id', 'model_id', 'title', 'keywords', 'description']);

        //执行更新逻辑
        $id = $request->input('id', 0);
        if($id){
            $contentModel = Content::find($id);

            $contentModel->update($arr);

            // 更新富文本字段
            foreach ($contentFileds as $filed){
                $contentModel->contents()->updateOrInsert(['content_id' => $id, 'field' => $filed], ['value' => Arr::get($params, $filed)]);
            }
            // 更新自定义字段
            foreach ($metaFileds as $filed){
                $contentModel->metas()->updateOrInsert(['content_id' => $id, 'field' => $filed], ['value' => Arr::get($params, $filed)]);
            }
            return response()->ajax();
        }

        $arr['user_id'] = auth()->user()->id;
        $arr['status'] = 1;
        $contentModel = Content::create($arr);

        // 保存富文本字段
        foreach ($contentFileds as $filed){
            $content = ['field' => $filed, 'value' => Arr::get($params, $filed)];
            $contentModel->contents()->create($content);
        }
        // 保存自定义字段
        foreach ($metaFileds as $filed){
            $meta = ['field' => $filed, 'value' => Arr::get($params, $filed)];
            $contentModel->metas()->create($meta);
        }
        return response()->ajax();
    }

    public function whole(Request $request)
    {
        $id = $request->input('id', 0);
        if(!$id){
            return response()->error('参数错误!');
        }
        $model = Content::with(['contents', 'metas'])->find($id);
        return response()->ajax($model);
    }
}
