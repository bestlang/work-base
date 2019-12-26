<?php

namespace App\Http\Controllers;

use App\Apis\Mp;
use App\Models\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use JWTAuth;
use Faker;
use App\Utils\WXBizDataCrypt;
use App\Services\UserService;
use Log;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;
use Mockery\Exception;

class MpController extends Controller
{
    // 响应消息
    public function serve()
    {
        Log::info('ra');
        $app = app('wechat.mini_program');
        $server = $app->server;

        $message = $server->getMessage();
//        Log::info($message);
        $FromUserName = $message['FromUserName'];
        if($message['MsgType'] === 'text'){
            $Content = $message['Content'];
            if($Content == '1'){
                $img = new Image(Cache::get('xzs_access_token'));// 18625072568微信号
                $result = $app->customer_service->message($img)->to($FromUserName)->send();
                $msg = new Text("长按识别二维码添加小助手为好友");
                $result = $app->customer_service->message($msg)->to($FromUserName)->send();
                return;
            }
            if($Content == '福利'){
                $img = new Image(Cache::get('xzs_access_token'));// 18625072568微信号
                $result = $app->customer_service->message($img)->to($FromUserName)->send();
                $msg = new Text("长按识别二维码添加小助手为好友");
                $result = $app->customer_service->message($msg)->to($FromUserName)->send();
                return;
            }
            if(false !== stripos($Content, '进群')){
                $img = new Image(Cache::get('xzs_access_token'));// 18625072568微信号
                $result = $app->customer_service->message($img)->to($FromUserName)->send();
                $msg = new Text("长按识别二维码添加小助手为好友,他将拉你入福利群. \n-----------\n 群内每天发放网购捡漏与限时福利!");
                $result = $app->customer_service->message($msg)->to($FromUserName)->send();
                return;
            }
            if(false !== stripos($Content, '福利')){
                $img = new Image(Cache::get('fwh_access_token'));// 服务号二维码图片
                $result = $app->customer_service->message($img)->to($FromUserName)->send();
                $msg = new Text("关注[刷福利]官方公众号, 天天刷现金红包,购物神券! \n-----------\n /:jj/:jj<a href='https://mobile.yangkeduo.com/duo_roulette.html?pid=1910307_23579444&cpsSign=CL_190627_1910307_23579444_f665ec89ab227ead1dab61f0c9eb648a&duoduo_type=2'>点我抽奖</a>");
                $result = $app->customer_service->message($msg)->to($FromUserName)->send();
                return;
            }
        }
        return $app->server->serve();
    }

    public function uploadImage(Request $request)
    {
        $path = "/images/sflxzs.jpeg";
        $path = public_path($path);
        $app = app('wechat.mini_program');
        $result = $app->media->uploadImage($path);
        $media_id = $result['media_id'];
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 解密微信小程序加密数据
     */
    public function decodeShareInfo(Request $request)
    {
        $appid = env('MP_APP_ID');
        $user = auth()->user();
        $sessionKey = json_decode($user->mp)->session_key;
        $decodeData = json_decode($request->input('getShareInfo'));

        $encryptedData=$decodeData->encryptedData;
        $iv = $decodeData->iv;

        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );

        $result = null;
        if ($errCode == 0) {
            $result = $data;
        } else {
            $result = $errCode;
        }

        return response()->json(['statusCode'=>'200','data'=>['decodeShareInfo'=>['result'=>$result]]]);
    }
    //小程序code换openid session_key等信息
    public function codeSession(Request $request)
    {
        $mp = new Mp();
        $result = $mp->codeSession($request->input('code'));
        $user = User::where('mp->openid',$result->openid)->first();
        $userInfo = null;
        if(!$user){
            $user = new User();
            $faker = app(Faker\Generator::class);
            $user->name = $faker->name();
            $user->password = bcrypt($user->name);//以随机用户名作为密码
            $user->email = $faker->userName().'@larashop.com';
        }else{
            $mp = $user->mp;
            if(isset($mp['userInfo'])){
                if($user->mobile){
                    $mp['userInfo']['mobile'] = $user->mobile;
                }
                if($user->wx){
                    $mp['userInfo']['wx'] = $user->wx;
                }
                $result->userInfo = $mp['userInfo'];
            }
        }
        $user->mp = $result;
        $user->save();
        return response()->json(['statusCode'=>'200','data'=>['jwt_token'=>JWTAuth::fromUser($user), 'openId'=>$result->openid, 'user'=>$user]]);
    }

    public function updateUserInfo(Request $request)
    {
        $user = auth()->user();
        $mp = $user->mp;
        $userInfo = $request->input('userInfo');
        $mp['userInfo'] = $userInfo;

        if(isset($mp['userInfo'])){
            if($user->mobile){
                $mp['userInfo']['mobile'] = $user->mobile;
            }
            if($user->wx){
                $mp['userInfo']['wx'] = $user->wx;
            }
        }
        $user->mp = $mp;
        $user->save();
        return response()->json(['statusCode'=>'200','data'=>['user' => $user]]);
    }

    /**
     * @param Request $request
     * @return null
     * 根据小程序openId获取数据库中用户的信息
     */
    public function getUserByMpOpenId(Request $request)
    {
        $openId = $request->input('openId');
        $user = UserService::getUserByMpOpenId($openId);

        return response()->json(['statusCode'=>'200', 'data'=>$user]);
    }

    // 确保上下级关系
    public function ensureRelationship(Request $request)
    {
        $userId = $request->input('userId');
        if(!$userId){
            $sharedUser = User::find(1);
        }else{
            $sharedUser = User::find($userId);
        }
        //
        $loginUser = auth()->user();

        $loginUserCreatedAt = strtotime($loginUser->created_at);
        if(time() - $loginUserCreatedAt < 10){
            $loginUser->parent_id = $sharedUser->id;
            $loginUser->save();
        }

        return response()->json(['statusCode'=>'200', 'data'=>$sharedUser]);
    }
}
