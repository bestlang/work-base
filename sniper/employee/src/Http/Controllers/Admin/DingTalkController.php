<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\DingTalk\Department as DingDepartment;
use Sniper\Employee\Models\DingTalk\User as DingUser;
use Sniper\Employee\Models\DingTalk\Attendance as DingAttendance;
use Sniper\Employee\Models\DingTalk\Leave;
use DB;

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
        //$users = DingUser::whereIn('department', $departmentIdArr)->get();
        $users = DB::connection('proxy')->table('sniper_employee_ding_users')->whereIn('department', $departmentIdArr)->get();
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

    //获取特定用户列表本月考勤状况
    public function usersAttendance(Request $request)
    {
        $userIds = $request->input('userIds');
        $month = $request->input('month');
        //$userIds = explode(',', $userIds);
        //未指定 本月
        $start = strtotime(date('Y-m-01')) * 1000;
        $end = ( strtotime(date('Y-m-t')) + 86400 ) * 1000;
        //指定了月份
        if($month){
            $start = strtotime(date($month.'-01')) * 1000;
            $end = ( strtotime(date($month.'-t')) + 86400 ) * 1000;
        }
        $attendances = DingAttendance::whereIn('userId', $userIds)->whereBetween('baseCheckTime', [$start, $end])->orderBy('baseCheckTime', 'asc')->orderBy('userId', 'desc')->get();
        $lastArr = [];
        foreach ($attendances as &$at){
            $at->hi = date('H:i',$at->userCheckTime/1000);
            $lastArr[$at->userId][$at->ymd][$at->checkType] = $at;
        }
        foreach ($lastArr as $userId => &$v){
            $leaves = Leave::where('userId', $userId)->where(function ($query)use($start, $end){
                    $query->where([['end_time', '>', $start], ['end_time', '<=', $end]])->orWhere([['start_time', '>=', $start], ['start_time', '<', $end]]);
                })->get();
            $lastArr[$userId]['leave'] = [];
            foreach ($leaves as $leave){
                $record = [
                    'start_time' => date('Y-m-d H:i:s', $leave->start_time/1000),
                    'end_time' => date('Y-m-d H:i:s', $leave->end_time/1000),
                ];
                $lastArr[$userId]['leave'][]= $record;
                $lastArr[$userId][date('Y-m-d', strtotime($record['start_time']))]['leave'] = $record;
            }
        }
        return response()->ajax($lastArr);
    }

    public function user(Request $request)
    {
        $userId = $request->input('userId');
        $user = null;
        try {
            $user = DingUser::with('departmentInfo')->where('userid', $userId)->firstOrFail();
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        return response()->ajax($user);
    }
}