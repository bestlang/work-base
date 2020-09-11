<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Department;
use Sniper\Employee\Models\User;
use Sniper\Employee\Models\Employee;
use Validator;

class EmployeeController
{
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $user = Employee::with('user')->find($id);
        return response()->ajax($user);
    }
    public function departmentEmployee(Request $request)
    {
        $query = Employee::query();
        $departmentId = $request->input('departmentId');
        $departmentIdArr = [];
        $departmentIdArr = Department::find($departmentId)
            ->getDescendantsAndSelf()
            ->map(function($item){return $item->id;})
            ->toArray();
        if(count($departmentIdArr)){
            array_push($departmentIdArr, ...$departmentIdArr);
        }
        $employee = Employee::with(['user', 'position'])->whereIn('department_id', $departmentIdArr)->get();
        return response()->ajax($employee);
    }
    public function save(Request $request)
    {
        $params = $request->all();
        $msg = '参数不合法';
        $rules = [
            'department_id' => 'required|numeric',
            'position_id' => 'required|numeric',
            'real_name' => 'required',
            'gender' => 'numeric|required',
            //'avatar' => 'nullable',
            'phone' => 'required|phone',
            'id_card' => 'required',
            'email' => 'required',
            //'password' => 'nullable',
            //'emergency' => 'nullable',
            'emergency_phone' => 'nullable|phone'
        ];
        $info = [
            'department_id.required' => '请选择部门',
            'department_id.numeric' => $msg,
            'position_id.required' => '请选择职位',
            'position_id.numeric' => $msg,
            'real_name.required' => '请录入真实姓名',
            'gender.numeric' => $msg,
            'gender.required' => '请选择性别',
            'phone.phone' => '请输入合法的手机号',
            'phone.required' => '请输入手机号',
            'id_card.required' => '请录入身份证号',
            'email.required' => '请录入公司邮箱',
            'emergency_phone.phone' => '请录入合法的紧急联系人手机号'
        ];
        $validator = Validator::make($params, $rules , $info , []);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $user_id = $request->input('user_id');
        $password = $request->input('password');
        if($user_id){//更新
            $user = User::find($user_id);
            $userData = [
                'name' => $params['real_name'],
                'email' => $params['email'],
            ];
            if($password){
                $userData['password'] = $password;
            }
            $user->update($userData);
            $user->employee->real_name = $params['real_name'];
            $user->employee->department_id = $params['department_id'];
            $user->employee->position_id = $params['position_id'];
            $user->employee->phone = $params['phone'];
            $user->employee->gender = $params['gender'];
            $user->employee->id_card = $params['id_card'];
            $user->push();
        }else{//新增
            $user = new User;
            $user->name = $params['real_name'];
            $user->password = bcrypt($params['password']);
            $user->email = $params['email'];
            $user->save();
            $user->employee()->create([
                'real_name' => $params['real_name'],
                'department_id' => $params['department_id'],
                'position_id' => $params['position_id'],
                'phone' => $params['phone'],
                'gender' => $params['gender'],
                'id_card' => $params['id_card'],
                'avatar' => $params['avatar'],
            ]);
            return response()->ajax($user);
        }
    }
}