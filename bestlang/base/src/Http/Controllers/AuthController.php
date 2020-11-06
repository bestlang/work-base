<?php
namespace BestLang\Base\Http\Controllers;

use BestLang\Base\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
//use Hash;
//use Validator;
use BestLang\Base\Factory\HistoryEventFactory;
use BestLang\Base\Http\Traits\PasswordModifyTrait;

class AuthController extends Controller
{
    use PasswordModifyTrait;
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
            if($token === false){
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
//    public function me()
//    {
//        return response()->ajax(auth()->user());
//    }

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

//    public function passwordModify(Request $request)
//    {
//        $params = $request->all();
//        $rules = [
//            'password' => 'required',
//            'new_password' => 'required|string|min:6',
//            'new_password_confirmation' => 'same:new_password'
//        ];
//        $info = [
//            'password.required' => '当前密码不能为空',
//            'new_password.required' => '新密码不能为空',
//            'new_password.string' => '新密码不能为空',
//            'new_password.min' => '新密码最少包含六个字符',
//            'new_password_confirmation.same' => '两次输入密码不一致',
//        ];
//        $validator = Validator::make($params, $rules, $info);
//        if($validator->fails()){
//            return response()->error($validator->errors()->first());
//        }
//        $user = auth()->user();
//        $password = $request->input('password');
//        $newPassword = $request->input('new_password');
//        if(Hash::check($password, $user->getAuthPassword())){
//            $user->password = bcrypt($newPassword);
//            $user->save();
//            return response()->ajax('密码修改成功！');
//        }else{
//            //密码不对
//            return response()->error('密码错误！');
//        }
//    }

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