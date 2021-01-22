<?php

namespace BestLang\Base\Http\Controllers\Admin;

use Illuminate\Http\Request;
use BestLang\Base\Models\App;
use BestLang\Base\Http\Controllers\Controller;
use Arr;

class AppController extends Controller
{
    public function index(Request $request)
    {
        $apps = App::all();
        return response()->ajax(['apps' => $apps]);
    }

    public function save(Request $request)
    {
        $params = $request->all();
        $id = Arr::get($params, 'id', 0);
        $name = Arr::get($params, 'name', '');
        $version = Arr::get($params, 'version', '');
        $tplNs = Arr::get($params, 'tplNs', '');
        $uri = Arr::get($params, 'uri', '');
        $arr = ['name' => $name, 'version' => $version, 'tplNs' => $tplNs, 'uri' => $uri];
        try{
            if($id){
                $app = App::find($id);
                if($app){
                    $app->update($arr);
                }
            }else{
                App::create($arr);
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
            $app = App::findOrFail($id);
            $app->delete();
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        return response()->ajax([]);
    }
}
