<?php

namespace BestLang\LaraCms\Http\Controllers\Admin\Cms;

use BestLang\LaraCms\Models\Cms\ChannelContent;
use BestLang\LaraCms\Models\Cms\ChannelMeta;
use BestLang\LaraCms\Models\Cms\Model;
use Illuminate\Http\Request;
use BestLang\LaraCms\Http\Controllers\Controller;
use BestLang\LaraCms\Models\Cms\Channel;
use Illuminate\Support\Arr;
use Validator;

class ChannelController extends Controller
{

    // get channels in tree format
    public function tree(Request $request)
    {
        if(!auth()->user()->can('cms list channels')){
            return response()->error('需要读取栏目列表权限!', 4012);
        }
        $params = $request->all();
        $disabled = Arr::get($params, 'disabled', false);
        $has_contents = Arr::get($params, 'has_contents', false);
        $tree = Channel::with('model')->get()->filter(function($item)use($has_contents){
            return $has_contents ? $item->model->has_contents : true;
        })->map(function($item)use($disabled){
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
        if(!auth()->user()->can('cms list channels')){
            return response()->error('需要读取栏目列表权限!', 4012);
        }
        $params = $request->validate([
            'parent_id' => 'nullable|numeric',
        ]);
        $parent_id = Arr::get($params, 'parent_id', 0);
        $children = Channel::where('parent_id', $parent_id)->get();
        return response()->ajax($children);
    }

    public function save(Request $request)
    {
        $channel = null;

        $request->validate([
            'parent_id' => 'nullable|numeric',
            'name' => 'required',
            'model_id' => 'required',
            'id' => 'nullable|numeric'
        ]);
        $params = $request->all();
        $parent_id = Arr::get($params, 'parent_id', 0);
        $name = Arr::get($params, 'name', '');
        $model_id = Arr::get($params, 'model_id', 0);

        $data = Arr::only($params, [
            'name',
            'title',
            'keywords',
            'description',
            'model_id',
            'content_template',
            'parent_id',
            'template'
            ]);

        $id = Arr::get($params, 'id', 0);

        if(!$name){
            return response()->error('栏目名不能为空');
        }
        if(!$model_id){
            return response()->error('请选择一个模型');
        }

        if($id){
            if(!auth()->user()->can('cms edit channels')){
                return response()->error('没有权限!', 4012);
            }
            $channel = Channel::find($id);
            if($parent_id){
                $parent = Channel::find($parent_id);
                $has = $parent->getDescendants(1)->contains(function($item)use($name, $channel){return $item->name == $name && $item->id != $channel->id;});
                if($has){
                    return response()->error('更新失败!父栏目包含同名子栏目');
                }
            }
            Channel::where('id', $id)->update($data);
        }else{
            if(!auth()->user()->can('cms add channels')){
                return response()->error('没有权限!', 4012);
            }
            if($parent_id){
                $parent = Channel::find($parent_id);
                $has = $parent->getDescendants(1)->contains(function($item)use($name){return $item->name == $name;});
                if($has){
                    return response()->error('添加失败!父栏目包含同名子栏目');
                }
            }
            $channel = Channel::create($data);
        }

        if($positions = $request->input('positions')){
            if(is_array($positions)){
                $channel->positions()->sync($positions);
            }
        }

        if($parent_id){
            $parent = Channel::find($parent_id);
            $channel->makeChildOf($parent);
        }

        $model = Model::find($model_id);
        $contentFileds = $model->fields->filter(function($item){return $item->is_channel == '1' && $item->type == 'content' && $item->is_custom == '1';});//->map(function($item){ return $item->field;})->toArray();
        // 自定义字段 不包含TDK
        $metaFileds = $model->fields->filter(function($item){return $item->is_channel == '1' && $item->type != 'content' && $item->is_custom == '1';});//->map(function($item){ return $item->field;})->toArray();

        if($id){
            // 更新富文本字段
            foreach ($contentFileds as $filed){
                $channel->metas()->updateOrInsert(['channel_id' => $id, 'field' => $filed->field], ['value' => Arr::get($params, $filed->field)]);
            }
            // 更新自定义字段
            foreach ($metaFileds as $filed){
                $value = Arr::get($params, $filed->field);
                // 对checkbox特殊处理
                if($filed->type === 'checkbox'){
                    $value = implode(',', $value);
                }
                $channel->metas()->updateOrInsert(['channel_id' => $id, 'field' => $filed->field], ['value' => $value]);
            }
        }else{
            // 保存富文本字段
            foreach ($contentFileds as $filed){
                $content = ['field' => $filed->field, 'value' => Arr::get($params, $filed->field)];
                $channel->metas()->create($content);
            }
            // 保存自定义字段
            foreach ($metaFileds as $filed){
                $value = Arr::get($params, $filed->field);
                // 对checkbox特殊处理
                if($filed->type === 'checkbox'){
                    $value = implode(',', $value);
                }
                $meta = ['field' => $filed->field, 'value' => $value];
                $channel->metas()->create($meta);
            }
        }
        return response()->ajax($channel);
    }

    public function delete(Request $request)
    {
        if(!auth()->user()->can('cms delete channels')){
            return response()->error('没有权限!', 4012);
        }
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
            if(count($model->articles)>0){
                return response()->error('栏目包含内容,无法删除!');
            }
            $model->delete();
            return response()->ajax();
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->error('模型不存在');
        }
        return response()->error('未知错误');
    }

    public function whole(Request $request)
    {
        if(!auth()->user()->can('cms list channels')){
            return response()->error('需要读取栏目列表权限!', 4012);
        }
        $id = $request->input('id', 0);
        if(!$id){
            return response()->error('参数错误!');
        }
        $channel = Channel::with(['contents', 'metas'])->find($id);
        // checkbox特殊处理,数据库中1,2,3取出之后封装成[1,2,3]
        $filedTypeMap = [];
        $channel->model->fields->filter(function($modelField){
            return $modelField->is_channel;
        })->each(function($modelField)use(&$filedTypeMap, &$channel){
            if($modelField->is_custom){
                if($modelField->type == 'content'){
                    //确保$content->contents里面包含此值
                    $has = $channel->contents->search(function($cc)use($modelField){
                        return $cc->field == $modelField->field;
                    });
                    if($has === false){
                        $cc = new ChannelContent();
                        $cc->content_id = $channel->id;
                        $cc->field = $modelField->field;
                        $cc->value = '';
                        $channel->contents->push($cc);
                    }
                }else{
                    //确保$content->metas里面此值存在,至少为空
                    $has = $channel->metas->search(function($cc)use($modelField){
                        return $cc->field == $modelField->field;
                    });
                    if($has === false){
                        $cm = new ChannelMeta();
                        $cm->content_id = $channel->id;
                        $cm->field = $modelField->field;
                        $cm->value = '';
                        $channel->metas->push($cm);
                    }
                }
                $filedTypeMap[$modelField->field] = $modelField->type;
            }
        });
        $channel->positions = $channel->positions()->get()->map(function($position){
            return $position->id;
        });
        $channel->metas->map(function($meta)use($filedTypeMap){
            $type = Arr::get($filedTypeMap, $meta->field, null);
            if($type == 'checkbox'){
                $meta->value = array_values(array_filter(explode(',', $meta->value)));
            }
        });
        return response()->ajax($channel);
    }
}
