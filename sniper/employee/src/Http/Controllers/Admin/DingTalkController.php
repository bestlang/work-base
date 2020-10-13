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
    protected function _nthWeek($day)
    {
        $time = strtotime($day);
        $wk_day = date('w', strtotime(date('Y-m-1 00:00:00', $time))) ? : 7; //今天周几
        $d = date('d', $time) - (8 - $wk_day); //今天几号
        return $d <= 0 ? 1 : ceil($d / 7) + 1;
    }

    public function _weekWorkDay($month)
    {
        $weekWorkDays = [];
        $types = DingAttendance::select('ymd', 'workType')->where('ymd', 'like', $month.'%')->where('checkType', 'OffDuty')->groupBy('ymd')->groupBy('workType')->get()->toArray();
        foreach ($types as $type){
            $nth = $this->_nthWeek($type['ymd']);
            if(!isset($weekWorkDays[$nth])){
                $weekWorkDays[$nth] = 0;
            }
            $weekWorkDays[$nth] += $type['workType'];
        }
        return $weekWorkDays;
    }
    //所有部门
    public function departments(Request $request)
    {
        if(auth()->user()->cant('hr list departments')){
            return response()->error('没有权限!', 4012);
        }
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
        $user = auth()->user();
        if($user->cant('hr attendance')){
            return response()->error('没有权限!', 4012);
        }
        $departmentIdArr = [];
        $id = $request->input('id');
        if(!$id){
            $id = DingDepartment::whereNull('parentid')->first()->id;
        }
        if($id){
            $department = DingDepartment::with('subs')->where('id', $id)->first();
            $this->_getUnder($department, $departmentIdArr);
        }
        $users = DB::connection('proxy')->table('sniper_employee_ding_users')->whereIn('department', $departmentIdArr)->get();
        $departmentsMap = [];
        $dingDepartments = DingDepartment::all();
        $dingDepartments->each(function($dd)use(&$departmentsMap){
            $departmentsMap[$dd->id] = $dd->name;
        });
        $users->map(function($user)use($departmentsMap){
            $user->department_info = $departmentsMap[$user->department];
        });
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

    public function _getLeaves($userIds, $month)
    {
        if(!is_array($userIds)){
            $userIds = [$userIds];
        }
        //未指定 本月
        $start = strtotime(date('Y-m-01')) * 1000;
        $end = ( strtotime(date('Y-m-t')) + 86400 ) * 1000;
        //指定了月份
        if($month){
            $start = strtotime(date($month.'-01')) * 1000;
            $end = ( strtotime(date($month.'-t')) + 86400 ) * 1000;
        }
        $query = Leave::query();
        if(count($userIds)){
            $query = $query->whereIn('userId', $userIds);
        }
        $leaves = $query->where(function ($query)use($start, $end){
            $query->where([['end_time', '>', $start], ['end_time', '<=', $end]])->orWhere([['start_time', '>=', $start], ['start_time', '<', $end]]);
        })->get();
        return $leaves;
    }
    //获取特定用户列表本月考勤状况
    public function usersAttendance(Request $request)
    {
        if(auth()->user()->cant('hr attendance')){
            return response()->error('没有权限!', 4012);
        }
        $userIds = $request->input('userIds', []);
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
            $w = ['日','一','二','三','四','五','六'][date('w', strtotime($at->ymd))];

            $t = ['休','班'][$at->workType];

            if(in_array($w, ['六','日']) && $t == '班'){
                    $at->w = $w . $t;
            }else if(in_array($w, ['一','二','三','四','五']) && $t == '休'){
                    $at->w = $w . $t;
            }else{
                $at->w = $w;
            }
            if($at->checkType == 'OnDuty'){
                $at->baseCheckTime = $at->workDate + 9 * 60 * 60 * 1000;
            }else{
                $at->baseCheckTime = $at->workDate + 18 * 60 * 60 * 1000;
            }
            $at->hi = date('H:i',$at->userCheckTime/1000);
            $lastArr[$at->userId][$at->ymd][$at->checkType] = $at;
        }
        foreach ($lastArr as $userId => &$v){
//            $leaves = Leave::where('userId', $userId)->where(function ($query)use($start, $end){
//                    $query->where([['end_time', '>', $start], ['end_time', '<=', $end]])->orWhere([['start_time', '>=', $start], ['start_time', '<', $end]]);
//                })->get();
            $leaves = $this->_getLeaves($userId, $month);
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

    public function weekAvg(Request $request)
    {
        if(auth()->user()->cant('hr attendance')){
            return response()->error('没有权限!', 4012);
        }
        $month = $request->input('month');
        $userId = $request->input('userId');

        if(!$month){
            $month = date('Y-m');
        }
        if(!$userId){
            return response()->error('参数错误');
        }
        $user = DingUser::where('userid', $userId)->first();
        $department = $user->department;
        $userIds = [];
        DingUser::where('department', $department)->get()->each(function($user)use(&$userIds){
            $userIds[] = $user->userid;
        });
        $weekWorkDays = $this->_weekWorkDay($month);
        $grp = [];

        $attendances = DB::connection('proxy')->table('sniper_employee_ding_attendance')->where('ymd', 'like', $month.'%')->whereIn('userId', $userIds)->get();
        foreach ($attendances as $at){
            $grp[$at->userId][$at->ymd][] = $at->userCheckTime/1000;
        }
        $udt = [];
        $leaves = $this->_getLeaves($userIds, $month);
        $hit = [];
        foreach ($leaves as $leave){
            $hit[$leave->userid][date('Y-m-d', $leave['start_time']/1000)] = 1;
        }
        foreach ($grp as $_userId => $daily){
            foreach ($daily as $day => $data){
                if(isset($hit[$_userId][$day])){//关联了请假
                    $udt[$_userId][$this->_nthWeek($day)][$day]  = 9 * 60 * 60;
                }else if(isset($data[0]) && isset($data[1])) {
                    $udt[$_userId][$this->_nthWeek($day)][$day] = abs($data[1] - $data[0]);
                }
            }
        }
        $temp = [];
        foreach ($udt as $_userId => $data){
            foreach ($data as $nth => $val){
                //$h = $weekWorkDays[$nth] ? round(array_sum($val) / ($weekWorkDays[$nth] * 60 * 60) - 1, 2) : 0;
                $b = min(count($val),$weekWorkDays[$nth]);
                $h = $b ? round(array_sum($val) / ($b * 60 * 60) - 1, 2) : 0;
                $temp[$_userId][$nth] = $h;
            }
        }
        $avg = [];
        collect([1,2,3,4,5,6])->each(function($i)use($temp, &$avg){
            $sum = 0;
            $count = 0;
            foreach ($temp as $id => $v){
                $sum += isset($v[$i]) ? $v[$i] : 0;
                if(isset($v[$i]) && $v[$i]){
                    $count += 1;
                }
            }

            $avg[$i] = $count ? round($sum / $count, 2) : 0;
        });

        $res = [];
        collect([1,2,3,4,5,6])->each(function($i)use(&$res,$avg, $userId, $temp){
            $h = 0;
            if(isset($temp[$userId]) && isset($temp[$userId][$i])){
                $h = $temp[$userId][$i];
            }
            if($h || isset($avg[$i]) && $avg[$i]){
                $res[] = ['第'.$i.'周', $h, isset($avg[$i]) ? $avg[$i] : 0];
            }

        });
        return response()->ajax($res);
    }
    public function departmentsWeekAvg(Request $request)
    {
        if(auth()->user()->cant('hr attendance')){
            return response()->error('没有权限!', 4012);
        }
        $month = $request->input('month');
        if(!$month){
            $month = date('Y-m');
        }
        $departments = DingDepartment::with(['subs', 'users'])->has('users')->get()->filter(function($department){
            return !count($department->subs);
        });
        $leaves = $this->_getLeaves([], $month);
        $hit = [];
        foreach ($leaves as $leave){
            $hit[$leave->userid][date('Y-m-d', $leave['start_time']/1000)] = 1;
        }
        $weekWorkDays = $this->_weekWorkDay($month);
        $res = [];
        $departmentNames = [];
        foreach ($departments as $department){
            $departmentNames[] = $department->name;
            $userIds = $department->users->map(function($user){
                return $user->userid;
            });
            $grp = [];
            $attendances = DB::connection('proxy')->table('sniper_employee_ding_attendance')->where('ymd', 'like', $month.'%')->whereIn('userId', $userIds)->get();
            foreach ($attendances as $at){
                $grp[$at->userId][$at->ymd][] = $at->userCheckTime/1000;
            }
            $udt = [];
            foreach ($grp as $_userId => $daily){
                foreach ($daily as $day => $data){
                    if(isset($hit[$_userId][$day])){//关联了请假
                        $udt[$_userId][$this->_nthWeek($day)][$day]  = 9 * 60 * 60;
                    }else if(isset($data[0]) && isset($data[1])) {
                        $udt[$_userId][$this->_nthWeek($day)][$day] = abs($data[1] - $data[0]);
                    }
                }
            }
            $temp = [];
            foreach ($udt as $_userId => $data){
                foreach ($data as $nth => $val){
                    $b = min(count($val),$weekWorkDays[$nth]);
                    $h = $b ? round(array_sum($val) / ($b * 60 * 60) - 1, 2) : 0;
                    $temp[$_userId][$nth] = $h;
                }
            }

            collect([1,2,3,4,5,6])->each(function($i)use($temp, &$res){
                $sum = 0;
                $count = 0;
                foreach ($temp as $_uid => $v){
                    $sum += isset($v[$i]) ? $v[$i] : 0;
                    if(isset($v[$i]) && $v[$i]){
                        $count += 1;
                    }
                }
                $depVal = $count ? round($sum / $count, 2) : 0;
                if(!isset($res[$i]) || !count($res[$i])){
                    $res[$i][] = '第'.$i.'周';
                }
                $res[$i][] = $depVal;
            });
        }
        return response()->ajax(['departmentNames' => $departmentNames, 'values' => array_values($res)]);
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