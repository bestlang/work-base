<?php
namespace BestLang\LaraCMS\Http\Controllers\Admin\Cms;

use BestLang\LaraCMS\Http\Controllers\Controller;
use BestLang\Base\Models\HashConfig as Config;

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
        $path = base_path().'/bestlang/laracms/resources/views/laracms/themes/';
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