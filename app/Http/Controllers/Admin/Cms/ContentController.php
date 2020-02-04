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
        $channel_id = $request->input('channel_id', 0);
        if(!$channel_id){
            $contents = Content::with('channel')->orderBy('id', 'desc')->get();
            return response()->ajax($contents);
        }else{
            $contents = Channel::find($channel_id)->contents()->with('channel')->orderBy('id', 'desc')->get();
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
        $channel_id = Arr::get($params, 'channel_id', 0);
        $model_id = Arr::get($params, 'model_id', 0);

        $channel = Channel::find($channel_id);
        $model = Model::find($model_id);


        $contentFileds = $model->fields->filter(function($item){return $item->type == 'content';})->map(function($item){ return $item->field;})->toArray();
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
            // @todo 更新自定义字段

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
        // @todo 保存自定义字段

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
