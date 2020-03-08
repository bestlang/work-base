<?php

namespace Bestlang\Laracms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Bestlang\Laracms\Http\Controllers\Controller;
use Upyun\Upyun;
use Upyun\Config;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        $file = $request->file('file');
        $destinationPath = 'uploads/';
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $serviceConfig = new Config(config('upyun.serviceName'), config('upyun.operatorName'), config('upyun.operatorPassword'));
        $client = new Upyun($serviceConfig);

        $path = $destinationPath.$filename;
        $fp = fopen($path, 'r');
        $up_response = $client->write($path, $fp);

        return response()->json(['statusCode'=>'200', 'data'=>['file'=>config('upyun.cdnPath').'/'.$path]]);
    }

    public function ueditor(Request $request)
    {
        $result = config('ueditor');
        $result = json_encode($result);
        $action = $request->input('action');
        if(strtolower($request->getMethod()) === 'post'){
        /*
        array(
            "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
            "url" => "",            //返回的地址
            "title" => "",          //新文件名
            "original" => "",       //原始文件名
            "type" => "",            //文件类型
            "size" => "",           //文件大小
        );
        */
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
    }
}
