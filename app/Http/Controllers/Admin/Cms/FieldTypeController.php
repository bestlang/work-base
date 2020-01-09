<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\FieldType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Arr;

class FieldTypeController extends Controller
{
    public function index(){
        $fieldTypes = FieldType::all();
        return response()->ajax($fieldTypes);
    }

    public function add(Request $request)
    {
        $params = $request->all();
        $rules = [
            'type' => 'required|alpha_dash',
            'name' => 'required'
        ];
        $infos = [
            'type.required' => '类型不能为空',
            'type.alpha_dash' => '类型只能为字母下划线组成',
            'name.required' => '名称不能为空'
        ];
        $names = [
            'type' => '类型',
            'name' => '名称'
        ];
        $validator = Validator::make($params, $rules, $infos, $names);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $data = Arr::only($params, ['type', 'name']);
        FieldType::create($data);
        return response()->ajax();
    }
}
