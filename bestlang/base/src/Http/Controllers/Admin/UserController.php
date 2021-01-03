<?php

namespace BestLang\Base\Http\Controllers\Admin;

use BestLang\Base\Models\User;
use Illuminate\Http\Request;
use BestLang\Base\Http\Controllers\Controller;
use Validator;
use BestLang\Base\Models\Role;
use Arr;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function info(Request $request)
    {
        $user = auth()->user()->with('roles')->get();
        if(!$user){
            return response()->error("login required", 401);
        }
        return response()->ajax(auth()->user());
    }

    public function create(Request $request)
    {
        if(!auth()->user()->can('privileges add users')){
            return response()->error('无权限！', 4012);
        }
        $params = $request->all();
        $rules = [
            'name' => 'required',
            'mobile' => 'nullable|mobile',
            'email' => 'email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'roles' => 'nullable|array'
        ];
        $info = [
            'name.required' => '昵称不得为空',
            'mobile.mobile' => '手机号格式不正确',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱在系统中已存在',
            'password.required' => '密码不得为空',
            'confirm_password.required' => '确认密码不得为空',
            'confirm_password.same' => '两次输入密码不一致',
            'roles.array' => '数据不合法'
        ];
        $fields = [
            'name' => '昵称',
            'mobile' => '手机号',
            'email' => '邮箱',
            'password' => '密码',
            'confirm_password' => '确认密码',
            'roles' => '角色'
        ];
        $validator = Validator::make($params, $rules , $info , $fields);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }

        $user = new User;
        $user->name = $params['name'];
        $user->mobile = $params['mobile'];
        $user->email = $params['email'];
        $user->password = bcrypt($params['password']);
        $user->save();
        if($params['roles']){
            $roleIds = Role::whereIn('name', $params['roles'])->pluck('id')->toArray();
            $user->roles()->sync($roleIds);
        }
        return response()->ajax($user);
    }

    public function update(Request $request)
    {
        if(!auth()->user()->can('privileges edit users')){
            return response()->error('无权限！', 4012);
        }
        $params = $request->all();
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'mobile' => 'nullable|mobile',
            'email' => 'email|unique:users,email,'.$params['id'].',id',
            'password' => 'nullable',
            'confirm_password' => 'nullable|same:password',
            'roles' => 'nullable|array'
        ];
        $info = [
            'id.required' => '参数缺失',
            'name.required' => '昵称不得为空',
            'mobile.mobile' => '手机号格式不正确',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱在系统中已存在',
            'confirm_password.same' => '两次输入密码不一致',
            'roles.array' => '数据不合法'
        ];
        $fields = [
            'id' => 'ID',
            'name' => '昵称',
            'mobile' => '手机号',
            'email' => '邮箱',
            'password' => '密码',
            'confirm_password' => '确认密码',
            'roles' => '角色'
        ];
        $validator = Validator::make($params, $rules , $info , $fields);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }

        $user = User::find($params['id']);
        $user->name = $params['name'];
        isset($params['mobile']) && $user->mobile = $params['mobile'];
        $user->email = $params['email'];
        isset($params['password']) && $user->password = bcrypt($params['password']);
        $user->save();
        if($params['roles']){
            $roleIds = Role::whereIn('name', $params['roles'])->pluck('id')->toArray();
            $user->roles()->sync($roleIds);
        }
        return response()->ajax($user);
    }

    public function createRoleUser(Request $request)
    {
        if(!auth()->user()->can('privileges add role users')){
            return response()->error('无权限！', 4012);
        }
        $params = $request->all();
        $rules = [
            'email' => 'required',
            'mobile' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'name' => 'required',
            'roles' => 'nullable|array'
        ];
        $info = [
            'email.required' => '邮箱必填',
            'mobile.required' => '手机号必填',
            'password.required' => '密码必填',
            'confirm_password.required' => '确认密码必填',
            'confirm_password.same' => '两次输入密码不一致',
            'roles.array' => '数据不合法'
        ];
        $fields = [
            'email' => '邮箱',
            'mobile' => '手机号',
            'password' => '密码',
            'confirm_password' => '确认密码',
            'name' => '昵称',
            'roles' => '角色'
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
        $arr = Arr::only($params, ['name', 'mobile', 'password', 'email']);
        $arr['password'] = bcrypt($arr['password']);
        DB::beginTransaction();
        try{
            $user = User::create($arr);
            if($params['roles']){
                $roleIds = Role::whereIn('name', $params['roles'])->pluck('id')->toArray();
                $user->roles()->sync($roleIds);
            }
        }catch (\Exception $e){
            DB::rollBack();
            return response()->error($e->getMessage());
        }
        DB::commit();
        return response()->ajax();
    }
}
