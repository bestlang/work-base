<?php
namespace BestLang\Base\Http\Traits;

use Illuminate\Http\Request;
use Validator;
use Hash;

trait PasswordModifyTrait
{
    public function passwordModify(Request $request)
    {
        $params = $request->all();
        $rules = [
            'password' => 'required',
            'new_password' => 'required|string|min:6',
            'new_password_confirmation' => 'same:new_password'
        ];
        $info = [
            'password.required' => '当前密码不能为空',
            'new_password.required' => '新密码不能为空',
            'new_password.string' => '新密码不能为空',
            'new_password.min' => '新密码最少包含六个字符',
            'new_password_confirmation.same' => '两次输入密码不一致',
        ];
        $validator = Validator::make($params, $rules, $info);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $user = auth()->user();
        $password = $request->input('password');
        $newPassword = $request->input('new_password');
        if(Hash::check($password, $user->getAuthPassword())){
            $user->password = bcrypt($newPassword);
            $user->save();
            return response()->ajax('密码修改成功！');
        }else{
            //密码不对
            return response()->error('密码错误！');
        }
    }
}