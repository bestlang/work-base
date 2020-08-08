<?php


namespace Bestlang\Laracms\Http\Controllers\Admin\Cms;
use Bestlang\Laracms\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
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