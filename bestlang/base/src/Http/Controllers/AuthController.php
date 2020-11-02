<?php

namespace BestLang\Base\Http\Controllers;

use BestLang\Base\Http\Controllers\Controller;

use BestLang\Base\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use JWTAuth;

use BestLang\Base\Factory\HistoryEventFactory;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try{
            $mobile = request()->input('mobile');
            $password = request()->input('password');
            $token = JWTAuth::attempt(['mobile' => $mobile, 'password' => $password]);
            if(!$token){
                $exists = User::where('mobile', $mobile)->first();
                if($exists){
                    throw new \Exception('密码错误,请重试!');
                }else{
                    throw new \Exception('手机号不存在,请重试!');
                }
            }
        }catch (\Exception $e){
            return response()->error($e->getMessage(), 4011);//暂时使用4011作为登录失败代码, 区别于登录信息失效401
        }
        event(HistoryEventFactory::loginEvent());
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->ajax(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        event(HistoryEventFactory::logoutEvent());

        auth()->logout();

        return response()->ajax();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->ajax([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => User::find(JWTAuth::user()->id)
        ]);
    }
}