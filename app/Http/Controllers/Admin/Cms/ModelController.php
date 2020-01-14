<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Model;
use App\Models\Cms\ModelField;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\FieldType;
use Illuminate\Support\Arr;

class ModelController extends Controller
{
    public function index()
    {
        $models = Model::all();
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
        $data = Arr::only($params, ['type','field','label', 'extra', 'is_channel']);
        $model = Model::find($params['model_id']);
        $model->fields()->create($data);
        return response()->ajax($params);
    }
}
