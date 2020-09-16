<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\DingTalk\Department as DingDepartment;
use Sniper\Employee\Models\DingTalk\User as DingUser;
use Sniper\Employee\Models\DingTalk\Attendance as DingAttendance;

class DingTalkController
{
    //所有部门
    public function departments(Request $request)
    {
        $departments = DingDepartment::all();
        $rootKey = 0;
        foreach ($departments as $key => &$department){
            if(!isset($department->children)){
                $department->children = [];
            }
            if(isset($department->parentid)){
                for($i=0;$i<count($departments); $i++){
                    if($departments[$i]->id == $department->parentid){
                        $children = $departments[$i]->children;
                        $children[] = $department;
                        $departments[$i]->children = $children;
                    }
                }
            }else{
                $rootKey = $key;
            }
        }
        return response()->ajax( $departments[$rootKey] );
    }
    //所属部门的用户
    public function departmentUsers(Request $request)
    {
        $departmentIdArr = [];
        $id = $request->input('id');
        if($id){
            $department = DingDepartment::with('subs')->where('id', $id)->first();
            $this->_getUnder($department, $departmentIdArr);
        }
        $users = DingUser::whereIn('department', $departmentIdArr)->get();
        return response()->ajax($users);
    }

    public function _getUnder($department, &$departmentIdArr)
    {
        $departmentIdArr[] = $department->id;
        if(count($department->subs)){
            foreach ($department->subs as $row){
                $model = DingDepartment::with('subs')->where('id', $row->id)->first();
                $this->_getUnder($model, $departmentIdArr);
            }
        }
    }

    //获取特定用户列表本周考勤状况
    public function usersAttendance(Request $request)
    {
        $userIds = $request->input('userIds');
        //$userIds = explode(',', $userIds);
        $start = strtotime(date('Y-m-01')) * 1000;
        $end = ( strtotime(date('Y-m-t')) + 85400 ) * 1000;
        $attendances = DingAttendance::whereIn('userId', $userIds)->whereBetween('baseCheckTime', [$start, $end])->orderBy('baseCheckTime', 'asc')->orderBy('userId', 'desc')->get();
        $lastArr = [];
        foreach ($attendances as $at){
            $lastArr[$at->userId][$at->ymd][$at->checkType] = $at;
        }
        return response()->ajax($lastArr);
    }
}