<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Model;
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

    public function add(Request $request)
    {
        $params = $request->all();
        $data = Arr::only($params, ['name', 'channel_template_prefix', 'content_template_prefix']);
        $model = Model::create($data);
        return response()->ajax($model);
    }

    public function get(Request $request)
    {
        $id = $request->input('id', 0);
        if($id){
            $model = Model::find($id);
            return response()->ajax($model);
        }else{
            return response()->error('参数不合法!');
        }
    }
}
