<?php

namespace BestLang\LaraCMS\Http\Controllers\Admin\Cms;

use BestLang\LaraCMS\Models\Cms\Tag;
use BestLang\LaraCMS\Services\ContentService;
use Illuminate\Http\Request;
use BestLang\LaraCMS\Http\Controllers\Controller;
use BestLang\LaraCMS\Models\Cms\Content;
use BestLang\LaraCMS\Models\Cms\Model;
use Arr;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->cant('cms list contents')){
            return response()->error('没有读取文章权限!', 4012);
        }
        $channelId = $request->input('channel_id', 0);
        $page = $request->input('page', 1);
        $keyword = $request->input('keyword', null);
        $pageSize = $request->input('page_size', 10);
        $res = ContentService::contents($channelId, $page, $pageSize, $keyword);
        return response()->ajax($res);
    }

    public function save(Request $request)
    {
        $content = null;
        $params = $request->all();
        $rules = [
            'channel_id' => 'required',
            'model_id' => 'required',
        ];
        $modelId = Arr::get($params, 'model_id', 0);

        $model = Model::find($modelId);
        if(!$model){
            response()->error('参数错误');
        }
        $contentFileds = $model->fields->filter(function($item){return $item->is_channel == '0' && $item->type == 'content' && $item->is_custom == '1';});
        // 自定义字段 不包含TDK
        $metaFileds = $model->fields->filter(function($item){return $item->is_channel == '0' && $item->type != 'content' && $item->is_custom == '1';});
        $arr = Arr::only($params, ['channel_id', 'model_id', 'title', 'keywords', 'description']);
        $tags = $request->input('tags', '');

        // 执行更新逻辑
        $id = $request->input('id', 0);
        if($id){
            if(auth()->user()->cant('cms edit contents')){
                return response()->error('没有读取文章权限!', 4012);
            }
            $content = Content::find($id);

            Content::where('id', $id)->update($arr);

            // 更新富文本字段
            foreach ($contentFileds as $filed){
                $content->contents()->updateOrInsert(['content_id' => $id, 'field' => $filed->field], ['value' => Arr::get($params, $filed->field)]);
            }
            // 更新自定义字段
            foreach ($metaFileds as $filed){
                $value =  Arr::get($params, $filed->field, null);
                if($value){
                    // 对checkbox特殊处理
                    if($filed->type === 'checkbox'){
                        $value = implode(',', $value);
                    }
                    if($filed->type === 'multiple-image' || $filed->type === 'attachment'){
                        $value = json_encode($value);
                    }
                }else{
                    if(is_array($value)){
                        $value = json_encode($value);
                    }
                }
                $content->metas()->updateOrInsert(['content_id' => $id, 'field' => $filed->field], ['value' => $value]);
            }
            // tags标签
            if($tags){
                try{
                    $tagIds = collect($tags)->map(function($tag){
                        if($tag['name']){
                            $tagModel = Tag::firstOrCreate(['name' => $tag['name']]);
                            return $tagModel->id;
                        }
                    })->toArray();
                    $tagIds = array_filter($tagIds);
                    $content->tags()->sync($tagIds);
                }catch (\Exception $e){
                    return response()->error($e->getMessage());
                }
            }
        }else{
            if(auth()->user()->cant('cms add contents')){
                return response()->error('没有读取文章权限!', 4012);
            }
            // 执行插入逻辑
            $arr['user_id'] = auth()->user()->id;
            $arr['status'] = 1;
            $content = Content::create($arr);

            // 保存富文本字段
            foreach ($contentFileds as $filed){
                $contentArr = ['field' => $filed->field, 'value' => Arr::get($params, $filed->field)];
                $content->contents()->create($contentArr);
            }
            // 保存自定义字段
            foreach ($metaFileds as $filed){
                $value = Arr::get($params, $filed->field, null);
                if($value){
                    // 对checkbox特殊处理
                    if($filed->type === 'checkbox'){
                        $value = implode(',', $value);
                    }
                    if($filed->type === 'multiple-image' || $filed->type === 'attachment'){
                        $value = json_encode($value);
                    }
                }else{
                    if(is_array($value)){
                        $value = json_encode($value);
                    }
                }
                $meta = ['field' => $filed->field, 'value' => $value];
                $content->metas()->create($meta);
            }
        }
        if($positions = $request->input('positions')){
            if(is_array($positions)){
                $content->positions()->sync($positions);
            }
        }
        // tags标签
        if($tags){
            try{
                $tagIds = collect($tags)->map(function($tag){
                    if($tag['name']){
                        $tagModel = Tag::firstOrCreate(['name' => $tag['name']]);
                        return $tagModel->id;
                    }
                })->toArray();
                $tagIds = array_filter($tagIds);
                $content->tags()->sync($tagIds);
            }catch (\Exception $e){
                return response()->error($e->getMessage());
            }
        }
        return response()->ajax();
    }

    public function whole(Request $request)
    {
        if(auth()->user()->cant('cms list contents')){
            return response()->error('没有读取文章权限!', 4012);
        }
        $id = $request->input('id', 0);
        if(!$id){
            return response()->error('参数错误!');
        }
        $content = ContentService::content($id);
        return response()->ajax($content);
    }

    public function delete(Request $request)
    {
        if(auth()->user()->cant('cms delete contents')){
            return response()->error('没有读取文章权限!', 4012);
        }
        $id = $request->input('id', 0);
        Content::destroy($id);
        return response()->ajax();
    }
}
