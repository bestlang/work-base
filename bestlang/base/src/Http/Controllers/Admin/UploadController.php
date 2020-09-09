<?php
namespace Bestlang\Base\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Upyun\Upyun;
use Upyun\Config;
use Bestlang\Base\Http\Controllers\Controller;

class UploadController extends Controller
{

    public function index(Request $request)
    {
        $file = $request->file('file');
        $destinationPath = 'uploads/';
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        /*$serviceConfig = new Config(config('upyun.serviceName'), config('upyun.operatorName'), config('upyun.operatorPassword'));
        $client = new Upyun($serviceConfig);

        $path = $destinationPath.$filename;
        $fp = fopen($path, 'r');
        $client->write($path, $fp);

        return response()->json(['statusCode'=>'200', 'data'=>['file'=>config('upyun.cdnPath').'/'.$path]]);
        */
        return response()->ajax(['file' => $destinationPath.$filename]);
    }

    /*
    public function ueditor(Request $request)
    {
        $result = config('ueditor');
        $result = json_encode($result);
        $action = $request->input('action');
        if($request->isMethod('post')){
            return [
                'state' => 'SUCCESS',
                'url' => 'https://dss1.bdstatic.com/5eN1bjq8AAUYm2zgoY3K/r/www/cache/static/protocol/https/home/img/qrcode/zbios_x2_5869f49.png',
            ];
        }
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        }
    }*/
}
