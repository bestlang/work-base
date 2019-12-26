<?php
namespace  App\Apis;

use App\ThemeListGet;
use App\TopGoodsListQuery;
use App\ThemeGoodsSearch;
use App\PddGoodsPromotionUrlGenerate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\VarExporter\Tests\FinalStdClass;

class Mp
{
    //通过 wx.login 接口获得临时登录凭证 code 后传到开发者服务器调用此接口完成登录流程
    public function codeSession($code)
    {
        $client = new Client();
        $params = [
            'appid' => env('MP_APP_ID'),
            'secret' => env('MP_APP_SECRET'),
            'js_code' => $code,
            'grant_type'=>'authorization_code'
        ];
        $response = $client->request('GET', 'https://api.weixin.qq.com/sns/jscode2session',['query'=>$params]);
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }
    // 获取小程序access_token
    public function refreshAccessToken()
    {
        $client = new Client();
        $params = [
            'appid' => env('MP_APP_ID'),
            'secret' => env('MP_APP_SECRET'),
            'grant_type'=>'client_credential'
        ];
        $response = $client->request('GET', 'https://api.weixin.qq.com/cgi-bin/token',['query'=>$params]);
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }

    // 生成小程序码
    // https://www.larashop.com/storage/acodes/oxWAR5R3027eXc-g4CCoFsb-6JfU.png
    public function genMpImage($userId, $force=false)
    {
        $baseDir = storage_path("app/public/acodes/");
        if(!file_exists($baseDir)){
            mkdir($baseDir, 0777, true);
        }
        $fileName = $userId.'.png';
        $file = $baseDir.$fileName;
        if(!file_exists($file) || $force){
            $client = new Client();
            $access_token = Cache::get('access_token');
            $page = 'pages/index/index';
            $params = [
                'scene' => "s={$userId}",
                'page' => $page,
                'width' => 280,
                'is_hyaline' => true
            ];
            $response = $client->request('post','https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token, ['json'=>$params]);
            file_put_contents($file, $response->getBody());
        }
        return "/storage/acodes/".$fileName;
    }
    // 生成商品小程序码
    public function genGoodsMpImage($userId, $goodsId, $force=true)
    {
        $baseDir = storage_path("app/public/acodes/goods/");
        if(!file_exists($baseDir)){
            mkdir($baseDir, 0777, true);
        }
        $fileName = 'pdd-'.$userId.'-'.$goodsId.'.png';
        $file = $baseDir.$fileName;
        if(!file_exists($file) || $force){
            $client = new Client();
            $access_token = Cache::get('access_token');
            $page = "pages/index/goodsDetail";
            $params = [
                'scene' => "goodsId={$goodsId}&s={$userId}",
                'page' => $page,
                'width' => 280,
                'is_hyaline' => true
            ];
            $response = $client->request('post','https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token, ['json'=>$params]);
            file_put_contents($file, $response->getBody());
        }
        return "/storage/acodes/goods/".$fileName;
    }
    // 定期生成客服消息图片
    public function csImage($path)
    {
        if(!$path)
            $path = "/images/sflxzs.jpeg";
        $path = public_path($path);
        $app = app('wechat.mini_program');
        $result = $app->media->uploadImage($path);
        $media_id = $result['media_id'];
        return $media_id;
    }

}