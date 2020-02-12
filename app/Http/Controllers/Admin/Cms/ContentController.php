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
        $model_id = Arr::get($params, 'model_id', 0);

        $model = Model::find($model_id);
        $contentFileds = $model->fields->filter(function($item){return $item->is_channel == '0' && $item->type == 'content' && $item->is_custom == '1';});
        // 自定义字段 不包含TDK
        $metaFileds = $model->fields->filter(function($item){return $item->is_channel == '0' && $item->type != 'content' && $item->is_custom == '1';});
        $arr = Arr::only($params, ['channel_id', 'model_id', 'title', 'keywords', 'description']);

        //执行更新逻辑
        $id = $request->input('id', 0);
        if($id){
            $contentModel = Content::find($id);

            $contentModel->update($arr);

            // 更新富文本字段
            foreach ($contentFileds as $filed){
                $contentModel->contents()->updateOrInsert(['content_id' => $id, 'field' => $filed->field], ['value' => Arr::get($params, $filed->field)]);
            }
            // 更新自定义字段
            foreach ($metaFileds as $filed){
                $value =  Arr::get($params, $filed->field, '');
                // 对checkbox特殊处理
                if($filed->type === 'checkbox'){
                    $value = implode(',', $value);
                }
                $contentModel->metas()->updateOrInsert(['content_id' => $id, 'field' => $filed->field], ['value' => $value]);
            }
            return response()->ajax();
        }

        $arr['user_id'] = auth()->user()->id;
        $arr['status'] = 1;
        $contentModel = Content::create($arr);

        // 保存富文本字段
        foreach ($contentFileds as $filed){
            $content = ['field' => $filed->field, 'value' => Arr::get($params, $filed->field)];
            $contentModel->contents()->create($content);
        }
        // 保存自定义字段
        foreach ($metaFileds as $filed){
            $value =  Arr::get($params, $filed->field, '');
            // 对checkbox特殊处理
            if($filed->type === 'checkbox'){
                $value = implode(',', $value);
            }
            $meta = ['field' => $filed->field, 'value' => $value];
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
        $content = Content::with(['contents', 'metas'])->find($id);
        // checkbox特殊处理,数据库中1,2,3取出之后封装成[1,2,3]
        $filedTypeMap = [];
        $content->model->fields->filter(function($item){
            return !$item->is_channel;
        })->each(function($item)use(&$filedTypeMap){
            if($item->is_custom){
                $filedTypeMap[$item->field] = $item->type;
            }
        });
        $content->metas->map(function($meta)use($filedTypeMap){
            if($filedTypeMap[$meta->field] == 'checkbox'){
                $meta->value = explode(',', $meta->value);
            }
        });

        return response()->ajax($content);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id', 0);
        Content::destroy($id);
        return response()->ajax();
    }
}
