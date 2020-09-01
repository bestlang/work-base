<?php


namespace Bestlang\Laracms\Http\Controllers\Admin\Cms;
use Bestlang\Laracms\Http\Controllers\Controller;
use Bestlang\Laracms\Models\Cms\Config;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    const KEY = 'site';

    public function getSetting(Request $request)
    {
        $arr = [];
        Config::where('key', self::KEY)->get()->each(function($item)use(&$arr){
            $arr[$item->field] = $item->value;
        });

        return response()->ajax($arr);
    }

    public function saveSetting(Request $request)
    {
        $params = $request->only([
            'title',
            'keywords',
            'description',
            'theme'
        ]);
        try{
            foreach ($params as $field => $value){
                Config::updateOrCreate(['key' => self::KEY, 'field' => $field], ['value' => $value]);
            }
            //throw new \Exception();
        }catch (\Exception $e){
            return response()->error('设置失败!');
        }
        return response()->ajax('设置成功!');
    }

    public function themes(Request $request)
    {
        $path = resource_path().'/views/vendor/laracms/';
        $resource = opendir($path);
        $themes = [];
        while($file = readdir($resource)){
            if($file !== '.' && $file !== '..'){
                $themes[] = $file;
            }
        }
        return response()->ajax($themes);
    }
}