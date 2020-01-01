<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Spatie\Permission\Models\Role;
use Arr;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $user = new User;
        $role_id = $request->input('role_id', '');
        $user->name = '花花';
        $user->password = bcrypt('123456');
        $user->save();
        return response()->ajax($user);
    }

    public function createRoleUser(Request $request)
    {
        $params = $request->all();
        $rules = [
            'role_id' => 'required|integer',
            'mobile' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
            'name' => 'required'
        ];
        $info = [
            'mobile.required' => '不得为空',
            'password.required' => '不得为空',
            'confirm_password.required' => '不得为空',
            'name.required' => '不得为空',
        ];
        $fields = [
            'role_id' => '角色ID',
            'mobile' => '手机号',
            'password' => '密码',
            'confirm_password' => '确认密码',
            'name' => '昵称'
        ];
        $validator = Validator::make($params, $rules , [] , $fields);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $password = Arr::get($params, 'password');
        $confirm_password = Arr::get($params, 'confirm_password');
        if($password != $confirm_password){
            return response()->error('两次输入密码不一致!');
        }
        $arr = Arr::only($params, ['name', 'mobile', 'password']);
        $arr['password'] = bcrypt($arr['password']);
        DB::beginTransaction();
        try{
            $user = User::create($arr);
            $role = Role::where('id', $params['role_id'])->firstOrFail();
            $user->assignRole($role);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->error($e->getMessage());
        }
        DB::commit();
        return response()->ajax();
    }
}
