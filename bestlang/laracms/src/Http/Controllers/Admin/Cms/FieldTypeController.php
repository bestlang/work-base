<?php

namespace BestLang\LaraCms\Http\Controllers\Admin\Cms;

use BestLang\LaraCms\Models\Cms\FieldType;
use Illuminate\Http\Request;
use BestLang\LaraCms\Http\Controllers\Controller;
use Validator;
use Arr;

class FieldTypeController extends Controller
{
    public function index(){
        $fieldTypes = FieldType::all();
        return response()->ajax($fieldTypes);
    }

    public function save(Request $request)
    {
        $params = $request->all();
        $rules = [
            'type' => 'required|alpha_dash|unique:cms_field_types',
            'name' => 'required',
            'extra' => 'required'
        ];
        if(Arr::get($params, 'id', false)){
            $rules['type'] = 'required|alpha_dash|unique:cms_field_types,type,'.$params['id'];
        }
        $info = [
            'type.unique' => '字段名字已存在',
            'type.required' => '字段不能为空',
            'type.alpha_dash' => '字段只能为字母下划线组成',
            'name.required' => '名称不能为空',
            'extra.required' => '附加信息不能为空'
        ];
        $names = [
            'type' => '类型',
            'name' => '名称',
            'extra' => '附加信息'
        ];
        $validator = Validator::make($params, $rules, $info, $names);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $data = Arr::only($params, ['type', 'name', 'extra']);

        $id = Arr::get($params, 'id', false);
        if($id){
            $fieldType = FieldType::find($id);
            if($fieldType){
                $fieldType->type = $data['type'];
                $fieldType->name = $data['name'];
                $fieldType->extra = $data['extra'];
                $fieldType->save();
            }
        }else{
            try{
                FieldType::create($data);
            }catch (\Exception $e){
                return response()->error($e->getMessage());
            }
        }
        return response()->ajax();
    }
}
