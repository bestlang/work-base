<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
