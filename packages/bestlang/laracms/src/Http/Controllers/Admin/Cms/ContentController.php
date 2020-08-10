<?php

namespace Bestlang\Laracms\Http\Controllers\Admin\Cms;

use Bestlang\Laracms\Models\Cms\Channel;
use Bestlang\Laracms\Models\Cms\ContentContent;
use Bestlang\Laracms\Models\Cms\ContentMeta;
use Bestlang\Laracms\Models\Cms\Tag;
use Illuminate\Http\Request;
use Bestlang\Laracms\Http\Controllers\Controller;
use Bestlang\Laracms\Models\Cms\Content;
use Bestlang\Laracms\Models\Cms\Model;
use Arr;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        if(!auth()->user()->can('cms list contents')){
            return response()->ajax('', 401);
        }
        $channelId = $request->input('channel_id', 0);
        $page = $request->input('page', 0);
        $keyword = $request->input('keyword', null);
        $page_size = $request->input('page_size', 10);

        $channelId = intval($channelId);
        $page = intval($page);
        $page_size = intval($page_size);

        $query = Content::query();
        if($keyword){
            $query = $query
                ->where('title', 'like', "%{$keyword}%")
                ->orWhere('keywords', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        }
        $total = $query->count();

        if(!$channelId){
            $contents = $query->with('channel')
                ->orderBy('id', 'desc')
                ->limit($page_size)
                ->offset(($page-1)*$page_size)
                ->get();
//            return response()->ajax(compact(['contents', 'total']));
        }else{
            $channelIdArr = [];
            $childrenIdArr = Channel::find($channelId)
                ->getDescendantsAndSelf()
                ->map(function($item){return $item->id;})
                ->toArray();
            if(count($childrenIdArr)){
                array_push($channelIdArr, ...$childrenIdArr);
            }
            $query->whereIn('channel_id', $channelIdArr);
            $total = $query->count();
            $contents = $query
                ->with(['channel', 'channel.content_template'])
                ->orderByRaw("case when `channel_id`=$channelId then 1 end desc")
                ->orderBy('id', 'desc')
                ->limit($page_size)
                ->offset(($page-1)*$page_size)
                ->get();
        }
        $contents->map(function($content){
            $content->link = route('content', $content->id);
            if(!$content->channel->content_template){
                $content->link = '';
            }
        });
        return response()->ajax(compact(['contents', 'total']));
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

        return response()->ajax();
    }

    public function whole(Request $request)
    {
        $id = $request->input('id', 0);
        if(!$id){
            return response()->error('参数错误!');
        }
        $content = Content::with(['contents', 'metas', 'tags'])->find($id);

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
        $content->positions = $content->positions()->get()->map(function($position){
            return $position->id;
        });
        /// checkbox特殊处理,数据库中1,2,3取出之后封装成[1,2,3]
        /// 多图特殊处理,以json根式存储
        $content->metas->map(function($meta)use($filedTypeMap){
            $type = Arr::get($filedTypeMap, $meta->field, null);
            if($type == 'checkbox' && $meta->value){
                $meta->value = array_values(array_filter(explode(',', $meta->value)));
            }
            if($type == 'multiple-image' || $type == 'attachment'){
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
