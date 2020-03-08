<?php

namespace Bestlang\Laracms\Http\Controllers\Admin\Cms;

use Bestlang\Laracms\Models\Cms\Model;
use Bestlang\Laracms\Models\Cms\ModelField;
use Illuminate\Http\Request;
use Bestlang\Laracms\Http\Controllers\Controller;
use Bestlang\Laracms\Models\Cms\FieldType;
use Illuminate\Support\Arr;

class ModelController extends Controller
{
    public function index()
    {
        $models = Model::with('fields')->get();
        return response()->ajax($models);
    }

    public function save(Request $request)
    {
        $params = $request->all();
        $data = Arr::only($params, ['name', 'channel_template_prefix', 'content_template_prefix']);
        $id = Arr::get($params, 'id', 0);
        if($id){
            $model = Model::find($id)->update($data);
        }else{
            $model = Model::create($data);
            // 同时创建模型系统字段(栏目,内容)
            $channelFields = [
                ['field' => 'title', 'type' => 'text', 'label' => '标题', 'is_required' => '1', 'is_channel' => '1', 'order_factor' => '1'],
                ['field' => 'keywords', 'type' => 'text', 'label' => '关键字', 'is_required' => '1', 'is_channel' => '1', 'order_factor' => '2'],
                ['field' => 'description', 'type' => 'textarea', 'label' => '描述', 'is_required' => '1', 'is_channel' => '1', 'order_factor' => '3'],
            ];
            $contentFields = [
                ['field' => 'title', 'type' => 'text', 'label' => '标题', 'is_required' => '1', 'is_channel' => '0', 'order_factor' => '1'],
                ['field' => 'keywords', 'type' => 'text', 'label' => '关键字', 'is_required' => '1', 'is_channel' => '0', 'order_factor' => '2'],
                ['field' => 'description', 'type' => 'textarea', 'label' => '描述', 'is_required' => '1', 'is_channel' => '0', 'order_factor' => '3'],
            ];
            foreach ($channelFields as $field){
                $model->fields()->create($field);
            }
            foreach ($contentFields as $field){
                $model->fields()->create($field);
            }
        }
        return response()->ajax($model);
    }

    public function get(Request $request)
    {
        $id = $request->input('id', 0);
        if($id){
            $model = Model::with('fields')->find($id);
            return response()->ajax($model);
        }else{
            return response()->error('参数不合法!');
        }
    }

    public function saveField(Request $request)
    {
        $params = $request->all();
        $rules = [
            'model_id' => 'required',
            'field' => 'required',
            'label' => 'required',
            'type' => 'required',
        ];
        $id = Arr::get($params, 'id', 0);
        $data = Arr::only($params, ['type','field','label', 'extra', 'is_channel']);
        $model = Model::find($params['model_id']);
        if($id){
            $field = $model->fields()->find($id);
            $field->update($data);
        }else{
            $data['is_custom'] = '1';
            $model->fields()->create($data);
        }

        return response()->ajax($params);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id', 0);
        $model = Model::find($id);
        // 如果模型被使用 禁止删除
        if(count($model->channels)){
            return response()->error('删除失败!模型被引用中');
        }
        $model->fields()->delete();
        $model->delete(); // Model::destroy($id);
        return response()->ajax();
    }

    public function deleteField(Request $request)
    {
        $params = $request->all();
        $model_id = Arr::get($params, 'model_id', 0);
        $id = Arr::get($params, 'id', 0);
        if(!$model_id || !$id){
            return response()->error('参数不合法');
        }
        $model = Model::find($model_id);
        $model->fields()->find($id)->delete();
        return response()->ajax();
    }

    public function saveFieldOrder(Request $request)
    {
        $ids = $request->input('ids', []);
        $orders = $request->input('orders', []);
        foreach ($ids as $index => $id){
            ModelField::find($id)->update(['order_factor' => $orders[$index]]);
        }
        return response()->ajax([$ids, $orders]);
    }
}
