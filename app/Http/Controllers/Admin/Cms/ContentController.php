<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Channel;
use App\Models\Cms\ContentContent;
use App\Models\Cms\ContentMeta;
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

        // 执行更新逻辑
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
                if($value){
                    // 对checkbox特殊处理
                    if($filed->type === 'checkbox'){
                        $value = implode(',', $value);
                    }
                    if($filed->type === 'multiple-image'){
                        $value = json_encode($value);
                    }
                }
                $contentModel->metas()->updateOrInsert(['content_id' => $id, 'field' => $filed->field], ['value' => $value]);
            }
            return response()->ajax();
        }
        // 执行插入逻辑
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
            if($value){
                // 对checkbox特殊处理
                if($filed->type === 'checkbox'){
                    $value = implode(',', $value);
                }
                if($filed->type === 'multiple-image'){
                    $value = json_encode($value);
                }
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

        $filedTypeMap = [];
        $content->model->fields->filter(function($item){
            return !$item->is_channel;
        })->each(function($modelField)use(&$filedTypeMap, &$content){
            if($modelField->is_custom){
                if($modelField->type == 'content'){
                    //确保$content->contents里面包含此值
                    $has = $content->contents->search(function($cc)use($modelField){
                        return $cc->field == $modelField->field;
                    });
                    if($has === false){
                        $cc = new ContentContent();
                        $cc->content_id = $content->id;
                        $cc->field = $modelField->field;
                        $cc->value = '';
                        $content->contents->push($cc);
                    }
                }else{
                    //确保$content->metas里面此值存在,至少为空
                    $has = $content->metas->search(function($cc)use($modelField){
                        return $cc->field == $modelField->field;
                    });
                    if($has === false){
                        $cm = new ContentMeta();
                        $cm->content_id = $content->id;
                        $cm->field = $modelField->field;
                        $cm->value = '';
                        $content->metas->push($cm);
                    }
                }
                //
                $filedTypeMap[$modelField->field] = $modelField->type;
            }
        });
        /// checkbox特殊处理,数据库中1,2,3取出之后封装成[1,2,3]
        /// 多图特殊处理,以json根式存储
        $content->metas->map(function($meta)use($filedTypeMap){
            $type = Arr::get($filedTypeMap, $meta->field, null);
            if($type == 'checkbox' && $meta->value){
                $meta->value = array_values(array_filter(explode(',', $meta->value)));
            }
            if($type == 'multiple-image' && $meta->value){
                $meta->value = json_decode($meta->value);
            }
        });
        ///
        return response()->ajax($content);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id', 0);
        Content::destroy($id);
        return response()->ajax();
    }
}
