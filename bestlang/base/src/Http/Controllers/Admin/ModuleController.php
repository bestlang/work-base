<?php

namespace BestLang\Base\Http\Controllers\Admin;

use Illuminate\Http\Request;
use BestLang\Base\Models\Module;
use BestLang\Base\Http\Controllers\Controller;
use Arr;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $modules = Module::all();
        return response()->ajax(['modules' => $modules]);
    }

    public function save(Request $request)
    {
        $params = $request->all();
        $id = Arr::get($params, 'id', 0);
        $name = Arr::get($params, 'name', '');
        $version = Arr::get($params, 'version', '');
        $tplNs = Arr::get($params, 'tplNs', '');
        $uri = Arr::get($params, 'uri', '');
        $is_default = Arr::get($params, 'is_default', '0');
        $type = Arr::get($params, 'type', '0');
        $arr = [
            'name' => $name,
            'version' => $version,
            'tplNs' => $tplNs,
            'uri' => $uri,
            'is_default' => $is_default,
            'type' => $type
        ];
        try{
            if($is_default){
                Module::whereRaw('1=1')->update(['is_default' => 0]);
            }
            if($id){
                $app = Module::find($id);
                if($app){
                    $app->update($arr);
                }
            }else{
                Module::create($arr);
            }
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        return response()->ajax([]);
    }

    public function del(Request $request)
    {
        $id = $request->input('id');
        try {
            $app = Module::findOrFail($id);
            $app->delete();
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        return response()->ajax([]);
    }
}
