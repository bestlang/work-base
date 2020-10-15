<?php

namespace Sniper\Employee\Http\Controllers\Admin;
use Sniper\Employee\Models\DingTalk\User as DingUser;
use Sniper\Employee\Models\DingTalk\Attendance;
use Illuminate\Http\Request;


class MixController
{
    //员工总数 出勤人数 请假人数
    public function today()
    {
        $totalEmployeeCount = DingUser::where('onJob', 1)->count();
        $todayAttendanceCount = Attendance::where('ymd', date('Y-m-d'))->where('checkType', 'OnDuty')->count();
        $baseOnDutyCheckTime = strtotime(date('Y-m-d 9:05'));
        $todayLateCount = Attendance::where('ymd', date('Y-m-d'))->where('checkType', 'OnDuty')->where('userCheckTime', '<', $baseOnDutyCheckTime * 1000)->count();
        return response()->ajax([
            'totalEmployeeCount' => $totalEmployeeCount,
            'todayAttendanceCount' => $todayAttendanceCount,
            'todayLateCount' => $todayLateCount
        ]);
    }
}