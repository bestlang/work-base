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
        $channelId = $request->input('channelId', 0);
        if(!$channelId){
            return response()->error('参数错误');
        }else{
            return response()->ajax([]);
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

        $arr = Arr::only($params, ['channel_id', 'model_id', 'title', 'keywords', 'description']);
        $arr['user_id'] = auth()->user()->id;
        $arr['status'] = 1;
        $contentModel = Content::create($arr);

        // 保存富文本字段
        $contentFileds = $model->fields->filter(function($item){return $item->type == 'content';})->map(function($item){ return $item->field;})->toArray();
        foreach ($contentFileds as $filed){
            $content = ['field' => $filed, 'content' => Arr::get($params, $filed)];
            $contentModel->contents()->create($content);
        }

        return response()->ajax();
    }
}
