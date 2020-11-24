<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Jobs\ProcessEditUser;
use Sniper\Employee\Models\Department;
use Sniper\Employee\Models\User;
use Sniper\Employee\Models\Employee;
use Validator;
use Arr;

class EmployeeController
{
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $employee = Employee::with(['user', 'education', 'job'])->find($id);
        $employee->leaving = json_decode($employee->leaving)??[];
        $employee->physical = json_decode($employee->physical)??[];
        $employee->certificate = json_decode($employee->certificate)??[];
        $employee->interview = json_decode($employee->interview)??[];
        return response()->ajax($employee);
    }
    public function departmentEmployee(Request $request)
    {
        if(!auth()->user()->can('hr list employee')){
            return response()->error('没有权限!', 4012);
        }
        $query = Employee::query();
        $departmentId = $request->input('departmentId');
        if(!$departmentId){
            $departmentId = Department::whereNull('parent_id')->first()->id;
        }
        $departmentIdArr = [];
        $departmentIdArr = Department::find($departmentId)
            ->getDescendantsAndSelf()
            ->map(function($item){return $item->id;})
            ->toArray();
        if(count($departmentIdArr)){
            array_push($departmentIdArr, ...$departmentIdArr);
        }
        $employee = Employee::with(['user.dingUser', 'position', 'department'])->whereIn('department_id', $departmentIdArr)->orderBy('department_id', 'asc')->get();
        return response()->ajax($employee);
    }
    public function save(Request $request)
    {
        $user = auth()->user();
        $params = $request->all();
        $msg = '参数不合法';
        $rules = [
            'department_id' => 'required|numeric',
            'position_id' => 'required|numeric',
            'real_name' => 'required',
            'gender' => 'numeric|required',
            'phone' => 'required|phone',
            'id_card' => 'required',
            'email' => 'required|email',
            'emergency_phone' => 'nullable|phone',
            //教育信息
            'educationHistory.*.start_time' => 'required',
            'educationHistory.*.end_time' => 'required|after:educationHistory.*.start_time',
            'educationHistory.*.school' => 'required',
            'educationHistory.*.unified' => 'required',
            'educationHistory.*.graduateType' => 'required|in:1,2',
            'educationHistory.*.isHigh' => 'required|in:0,1',
            'educationHistory.*.isFirst' => 'required|in:0,1',
            //工作信息
            'jobHistory.*.start_time' => 'required',
            'jobHistory.*.end_time' => 'required|after:jobHistory.*.start_time',
            'jobHistory.*.company' => 'required',
            'jobHistory.*.position' => 'required',
            'jobHistory.*.witness_phone' => 'phone|nullable',
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
            'emergency_phone.phone' => '请录入合法的紧急联系人手机号',

            'educationHistory.*.start_time.required' => '教育经历开始日期必填',
            'educationHistory.*.end_time.required' => '教育经历结束日期必填',
            'educationHistory.*.end_time.after' => '教育经历结束日期不得小于开始日期',
            'educationHistory.*.school.required' => '教育经历学校必填',
            'educationHistory.*.unified.required' => '',
            'educationHistory.*.graduateType.in' => '请选择毕业类型',
            'educationHistory.*.isHigh.in' => '请选择是否最高学历',
            'educationHistory.*.isFirst.in' => '请选择是否第一学历',

            'jobHistory.*.start_time.required' => '工作经历开始日期必填',
            'jobHistory.*.end_time.required' => '工作经历结束日期必填',
            'jobHistory.*.end_time.after' => '工作经历结束日期不得小于开始日期',
            'jobHistory.*.company.required' => '工作经历企业必填',
            'jobHistory.*.position.required '=> '工作经历岗位必填',
            'jobHistory.*.witness_phone.phone' => '证明人电话格式不正确'
        ];
        $validator = Validator::make($params, $rules , $info , []);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $user_id = $request->input('user_id');
        $password = $request->input('password');
        if($user_id){//更新
            if(!$user->can('hr edit employee') ){
                return response()->error('没有权限!', 4012);
            }
            $user = User::find($user_id);
            $dingUser = $user->dingUser;
            $userData = [
                'name' => $params['real_name'],
                'email' => $params['email'],
                'mobile' => $params['phone']
            ];
            if($password){
                $userData['password'] = bcrypt($password);
            }
            $user->update($userData);
            $user->employee->real_name = $params['real_name'];
            $user->employee->department_id = $params['department_id'];
            $user->employee->position_id = $params['position_id'];
            $user->employee->phone = $params['phone'];
            $user->employee->gender = $params['gender'];
            $user->employee->id_card = $params['id_card'];
            //扩展信息
            $user->employee->marital = $request->input('marital', 3);
            $user->employee->mate = $request->input('mate');
            $user->employee->children = $request->input('children');
            $user->employee->work_place = $request->input('work_place');
            $user->employee->native_land = $request->input('native_land');
            $user->employee->birthday = $request->input('birthday');
            $user->employee->birthday = $request->input('birthday');
            $user->employee->tag = $request->input('tag');
            //入职材料
            $user->employee->leaving = json_encode($request->input('leaving',[]));
            $user->employee->physical = json_encode($request->input('physical',[]));
            $user->employee->certificate = json_encode($request->input('certificate', []));
            $user->employee->interview = json_encode($request->input('interview',[]));

            $user->push();
             $attr = [
                'userid' => $dingUser->userid,
                'name' => $user->name,
                'email' => $user->email,
                'orgEmail' => $user->email,
                //'tel' => $user->employee->phone 分机号 不是手机, 改不了.
            ];
            ProcessEditUser::dispatch('U', $attr)->onQueue('updateDingTalkUser');//
            $user->dingUser->email = $user->email;
            $user->dingUser->orgEmail = $user->email;
            $user->push();
            ///存储教育经历
            $educationHistory = $request->input('educationHistory');
            foreach ($educationHistory as $k => $education){
                $data = Arr::except($education, ['id']);
                $data['orderFactor'] = $k;
                $model = $user->employee->education()->find($education['id']);
                if($model){
                    $model->update($data);
                }else{//id找不到或者为临时fake id
                    $user->employee->education()->create($data);
                }
            }
            ///
            ///存储工作经历
            $jobHistory = $request->input('jobHistory');
            foreach ($jobHistory as $k => $job){
                $data = Arr::except($job, ['id']);
                $data['orderFactor'] = $k;
                $model = $user->employee->job()->find($job['id']);
                if($model){
                    $model->update($data);
                }else{//id找不到或者为临时fake id
                    $user->employee->job()->create($data);
                }
            }
            ///
            return response()->ajax();
        }else{//新增
            if( !$user->can('hr add employee') ){
                return response()->error('没有权限!', 4012);
            }
            $user = new User;
            $user->name = $params['real_name'];
            $user->password = bcrypt($params['password']);
            $user->email = $params['email'];
            $user->mobile = $params['phone'];
            $user->save();
            $user->employee()->create([
                'real_name' => $params['real_name'],
                'department_id' => $params['department_id'],
                'position_id' => $params['position_id'],
                'phone' => $params['phone'],
                'gender' => $params['gender'],
                'id_card' => $params['id_card'],
                'avatar' => $params['avatar'],
                //扩展信息
                'marital'=> $request->input('marital', 3),
                'mate' => $request->input('mate'),
                'children' => $request->input('children'),
                'work_place' => $request->input('work_place'),
                'native_land' => $request->input('native_land'),
                'birthday' => $request->input('birthday'),
                'birthday' => $request->input('birthday'),
                'tag' => $request->input('tag'),
            ]);
            // 新建用户
            ///存储教育经历
            $educationHistory = $request->input('educationHistory');
            foreach ($educationHistory as $education){
                $row = Arr::except($education, ['id']);
                $user->employee->education()->create($row);
            }
            ///
            ///存储工作经历
            $jobHistory = $request->input('jobHistory');
            foreach ($jobHistory as $job){
                $row = Arr::except($job, ['id']);
                $user->employee->job()->create($row);
            }
            ///
            return response()->ajax($user);
        }
    }
}