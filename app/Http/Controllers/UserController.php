<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Pdd\PddOrder;

/**
 * @group 登录注册相关
 */
class UserController extends Controller
{
    //
    public $loginAfterSignUp = true;
    public function whiteList()
    {
        $whiteList = User::where('white', 1)->pluck('id')->toArray();
        return response()->json(['statusCode'=>'200', 'data'=>$whiteList]);
    }
    public function getUserById(Request $request)
    {
        $userId = $request->input('userId');
        if($userId){
            $user = User::find($userId);
            return response()->json(['statusCode'=>'200', 'data'=>$user]);
        }
    }
    public function register(RegisterAuthRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json(['statusCode'=>'200', 'data'=>['user' => $user]], 200);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = JWTAuth::attempt($input);
        if (!$jwt_token) {
            return response()->json(['statusCode'=>'401', 'data'=>[], 'message' => 'Invalid Email or Password'], 200);
        }

        return response()->json(['statusCode'=>'200', 'data'=>['accessToken' => $jwt_token]], 200);
    }

//    public function logout(Request $request)
//    {
////        $this->validate($request, [
////            'token' => 'required'
////        ]);
//
//        try {
//            JWTAuth::invalidate($request->token);
//            return response()->json(['statusCode'=>'200', 'data'=>[], 'message' => 'User logged out successfully'], 200);
//        } catch (JWTException $exception) {
//            return response()->json(['statusCode'=>'500', 'data'=>[], 'message' => 'Sorry, the user cannot be logged out'], 200);
//        }
//    }

    public function refresh(Request $request)
    {
        return response()->json(['statusCode'=>'200', 'data'=>['accessToken' => JWTAuth::refresh()]]);
    }

//    /**
//     * @bodyParam token 字符串 required token.
//     * @response {
//    "user": {
//    "id": 4,
//    "name": "luzhang",
//    "email": "luzhang110@163.com",
//    "email_verified_at": null,
//    "created_at": "2019-06-17 09:30:08",
//    "updated_at": "2019-06-17 09:30:08"
//    }
//    }
//     */
    public function getAuthUser(Request $request)
    {

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

    // 获取返利比例
    public function fRate()
    {
        $data = config('f');
        return response()->json(['statusCode'=>'200', 'data' => $data]);
    }
    // 返利等级
    public function fLevel()
    {
        $data = config('level');
        return response()->json(['statusCode'=>'200', 'data' => $data]);
    }

    public function pddOrderStatus()
    {
        $data = config('pddorderstatus');
        return response()->json(['statusCode'=>'200', 'data' => $data]);
    }

    public function submitWx(Request $request)
    {
        $wx = $request->input('wx','');
        $user = auth()->user();
        if($wx){
            $user->wx = $wx;
            $user->save();
        }
        return response()->json(['statusCode'=>'200', 'data' => ['message'=>'ok']], 200);
    }

    public function submitMobile(Request $request)
    {
        $mobile = $request->input('mobile','');
        $user = auth()->user();
        if($mobile){
            $user->mobile = $mobile;
            $user->save();
        }
        return response()->json(['statusCode'=>'200', 'data' => ['message'=>'ok']], 200);
    }

    public function parentUser(Request $request)
    {
        $user = auth()->user();
        $parent_id = $user->parent_id;
        if(!$parent_id){
            $data = ['userInfo'=>'', 'success'=>'0'];
        }else{
            $parent = User::find($parent_id);
            if($parent){
                $mp = $parent->mp;
                if(isset($mp['userInfo'])){
                    $data = ['userInfo'=>$mp['userInfo'], 'success'=>'1'];
                }else{
                    $u = new \stdClass();
                    $u->nickName = '神秘用户';
                    $u->avatarUrl = config('app.url').'/images/touxiang.png';
                    $data = ['userInfo'=>$u, 'success'=>'2'];
                }
            }
        }
        return response()->json(['statusCode'=>'200', 'data' => $data], 200);
    }

    public function isNewbie(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $bCount = PddOrder::where('custom_parameters', $user_id.'B')->count();
        return response()->json(['statusCode'=>'200', 'data' => ['isNewbie'=>$bCount>0 ? 0 : 1]], 200);
    }
}
