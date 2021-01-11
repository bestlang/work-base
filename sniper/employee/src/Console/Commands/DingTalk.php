<?php

namespace Sniper\Employee\Console\Commands;

use Arr;
use DB;
use Illuminate\Console\Command;
use Sniper\Employee\Models\Department;
use Sniper\Employee\Models\DepartmentArchive;
use Sniper\Employee\Models\DingTalk\Attendance;
use Sniper\Employee\Models\DingTalk\Department as DingDepartment;
use Sniper\Employee\Models\DingTalk\Leave;
use Sniper\Employee\Models\DingTalk\User as DingUser;
use Sniper\Employee\Models\Employee;
use Sniper\Employee\Models\Position;
use Sniper\Employee\Models\User;
use Sniper\Employee\Services\DingTalk as DingService;
use Sniper\Employee\Mail\LateNotice;
use Sniper\Employee\Mail\LateNoticeLeader;
use Mail;
use Log;
use Sniper\Employee\Models\DingTalk\Attendance as DingAttendance;
use Sniper\Employee\Models\WeeklyAttendance;

class DingTalk extends Command
{
    /**
     * The name and signature of the console command.
     * php artisan sniper:dingTalk attendance
     *
     * @var string
     */
    protected $signature = 'sniper:dingTalk {act}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dingTalk related';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function _syncDepartments($parent, $dingSubs)
    {

        $beforeSubIds = $parent->children->map(function($child){
            return $child->id;
        })->toArray();

        $afterSubIds = [];

        foreach ($dingSubs as $dingSub){
            $child = Department::updateOrCreate(['id' => $dingSub->id, 'name' => $dingSub->name]);
            $child->makeChildOf($parent);
            $afterSubIds[] = $child->id;
            if($dingSub->subs){
                $this->_syncDepartments($child, $dingSub->subs);
            }
        }

        $diffIds = array_diff($beforeSubIds, $afterSubIds);
        if($diffIds){
            Department::destroy($diffIds);
        }
    }

    public function _nthWeek($day)
    {
        $time = strtotime($day);
        $wk_day = date('w', strtotime(date('Y-m-1 00:00:00', $time))) ? : 7; //今天周几
        $d = date('d', $time) - (8 - $wk_day); //今天几号
        return $d <= 0 ? 1 : ceil($d / 7) + 1;
    }
    /**
     * @param DingService $ding
     */
    public function handle(DingService $ding)
    {
            $act = $this->argument('act');
            //同步数据到DingUser表
            if($act == 'users'){
                $departments = $ding->departments();
                $departmentIds = $departments['departmentIds'];
                $users = [];
                foreach ($departmentIds as $departmentId){
                    $users[] = $ding->_getDepartmentUsers($departmentId);
                }
                $allUsers = Arr::flatten($users);
                foreach($allUsers as $u){
                    $user = $ding->_getUser($u->userid);
                    if($user && isset($user->userid)){
                        DingUser::updateOrCreate(['unionid' => $user->unionid, 'openId' =>$user->openId] , [
                            'userid' => $user->userid,
                            'errcode' => $user->errcode,
                            'remark' => isset($user->remark) ? $user->remark : '',
                            'isLeaderInDepts' => explode(':', substr($user->isLeaderInDepts, 1, -1))[1] == 'true' ? 1 : 0,
                            'isBoss' => $user->isBoss,
                            'hiredDate' => isset($user->hiredDate) ? $user->hiredDate : '',
                            'isSenior' => $user->isSenior,
                            'tel' => isset($user->tel) ? $user->tel : '',
                            'department' => $user->department[0],
                            'workPlace' => isset($user->workPlace) ? $user->workPlace : '',
                            'email' => isset($user->email) ? $user->email : '',
                            'orgEmail' => isset($user->orgEmail) ? $user->orgEmail : '',
                            'orderInDepts' => explode(':', substr($user->orderInDepts, 1, -1))[1],
                            'mobile' => isset($user->mobile) ? $user->mobile : '',
                            'errmsg' => $user->errmsg,
                            'active' => $user->active,
                            'avatar' => $user->avatar,
                            'isAdmin' => $user->isAdmin,
                            'isHide' => $user->isHide,
                            'jobnumber' => isset($user->jobnumber) ? $user->jobnumber : '',
                            'name' => $user->name,
                            'extattr' => isset($user->extattr) ? $user->extattr : '',
                            'stateCode' => isset($user->stateCode) ? $user->stateCode : '',
                            'position' => isset($user->position) ? $user->position : '',
                            'roles' => isset($user->roles) ? json_encode($user->roles) : '',
                        ]);
                    }
                }
                $ding->_offJob();
            }else if($act == 'departments'){
                $departments = $ding->departments();
                $rawDepartments = $departments['rawDepartments'];
                foreach ($rawDepartments as $dep){
                    DingDepartment::updateOrCreate(['id' => $dep->id],
                        [
                            'name' => $dep->name,
                            'parentid' => isset($dep->parentid) ? $dep->parentid : null,
                            'createDeptGroup' => $dep->createDeptGroup,
                            'autoAddUser' => $dep->autoAddUser,
                            'ext' => isset($dep->ext) ? $dep->ext : ''
                        ]);
                }
                //去掉被删除的部门
                $date = date('Y-m-d H:00:00');
                DingDepartment::where('updated_at', '<', $date)->delete();
            }else if ($act == 'syncDepartments'){
                $dingDepartment = DingDepartment::whereNull('parentid')->first();
                $parent = Department::updateOrCreate(
                    ['id' => $dingDepartment->id],
                    [
                        'name' => $dingDepartment->name,
                        'parent_id' => $dingDepartment->parentid,
                    ]
                );
                $dingSubs = $dingDepartment->subs;
                $this->_syncDepartments($parent, $dingSubs);
                //去掉被删除的部门
                $date = date('Y-m-d H:00:00');
                Department::where('updated_at', '<', $date)->delete();
            }else if($act == 'syncUsers'){
                $dingUsers = DB::connection('proxy')->table('sniper_employee_ding_users')->get();
                foreach ($dingUsers as $dingUser){
                    if(!$dingUser->orgEmail){
                        $dingUser->orgEmail = substr($dingUser->unionid, 0, 10).'@sniper-tech.com';
                    }
                    $user = User::where(['email' => $dingUser->orgEmail, 'name' => $dingUser->name])->first();
                    if(!$user){
                        $user = User::create(['email' => $dingUser->orgEmail, 'name' => $dingUser->name, 'password' => bcrypt('111111')]);
                        $user->employee()->create([
                            'real_name' => $dingUser->name,
                            'department_id' => $dingUser->department,//使用dingTalk自带的department编号插入
                            'avatar' => $dingUser->avatar,
                            'userid' => $dingUser->userid
                        ]);
                    }else{
                        if(!$user->employee){
                            $user->employee()->create([
                                'real_name' => $dingUser->name,
                                'department_id' => $dingUser->department,//使用dingTalk自带的department编号插入
                                'avatar' => $dingUser->avatar
                            ]);
                        }else {
                            $user->employee->real_name = $dingUser->name;
                            $user->employee->department_id = $dingUser->department;
                            $user->employee->avatar = $dingUser->avatar;
                            $user->employee->userid = $dingUser->userid;
                            $user->push();
                        }
                    }
                }
            }else if($act == 'attendance'){
                $dateBegin = date('Y-m-d 00:00:00');
                $userIdsAll = DB::connection('proxy')->table('sniper_employee_ding_users')->pluck('userid')->toArray();
                $userIdsChunk = array_chunk($userIdsAll, 30);
                foreach ($userIdsChunk as $userIds){
                    for($days = 0; $days<170; $days++){
                        $workDateFrom = date('Y-m-d H:i:s',strtotime($dateBegin) - $days * 86400);
                        $workDateTo = date('Y-m-d H:i:s',strtotime($workDateFrom) + 86400);
                        echo "\n--------------------------query {$workDateFrom}-------------------------:\n";
                        $offset = 0;
                        $limit = 50;
                        while($attendances = $ding->_getUserAttendance($userIds, $workDateFrom, $workDateTo, $offset, $limit)){
                            foreach ($attendances as $att){
                                echo date("Y-m-d", $att->workDate/1000), "::", date("Y-m-d", $att->userCheckTime/1000),  "::", json_encode($att),"\n";
                                if(!$att->userId){
                                    throw new \Exception('拉取出勤信息出错！');
                                }
                                Attendance::updateOrCreate(
                                    ['userId' => $att->userId,"workDate" => $att->workDate, "ymd" => date('Y-m-d',$att->baseCheckTime / 1000), "checkType" => $att->checkType],
                                    [
                                        'id' => $att->id,
                                        "baseCheckTime" => $att->baseCheckTime,
                                        "corpId" => $att->corpId,
                                        "groupId" => $att->groupId,
                                        "locationResult" => $att->locationResult,
                                        "planId" => $att->planId,
                                        "recordId" => isset($att->recordId) ? $att->recordId : '',
                                        "timeResult" => $att->timeResult,
                                        "userCheckTime" => $att->userCheckTime,
                                        "workDate" => $att->workDate,
                                        "procInstId" => isset($att->procInstId) ? $att->procInstId : '',
                                        "approveId" => isset($att->approveId) ? $att->approveId : ''
                                    ]);
                            }
                            $offset += $limit;
                        }
                    }
                }


            }else if($act == 'process'){
                $time = time();
                $attendances = Attendance::where('procInstId', '!=', '')->get();
                foreach ($attendances as $attendance){
                    if($time - $attendance->baseCheckTime/1000 < 180 * 86400){
                        $result = $ding->_getProcess($attendance->procInstId);
                        echo "================\n";
                        echo $attendance->procInstId, ":",  json_encode($result),"\n";
                    }
                }
            }else if($act == 'leaveStatus'){
                $userIds = DB::connection('proxy')->table('sniper_employee_ding_users')->pluck('userid')->toArray();
                $userid_list = implode(',', $userIds);
                $end_time = time() * 1000;
                $start_time = $end_time - 180 * 86400 * 1000;
                $offset = 0;
                $size = 20;
                $result = $ding->_getLeaveStatus($userid_list, $start_time, $end_time, $offset, $size);
                echo $offset, "\n";
                $leave_status = [];
                $leave_status[] = $result->result->leave_status;
                while($result->result->has_more){
                    $offset += $size;
                    echo $offset, "\n";
                    $result = $ding->_getLeaveStatus($userid_list, $start_time, $end_time, $offset, $size);
                    $leave_status[] = $result->result->leave_status;
                }
                $leave_status = Arr::flatten($leave_status);
                foreach ($leave_status as $leave){
                    $userid = $leave->userid;
                    $start_time = $leave->start_time;
                    $end_time = $leave->end_time;
                    Leave::updateOrCreate([
                        'userid' => $userid,
                        'start_time' => $start_time
                    ],[
                        'end_time' => $end_time
                    ]);
                }
//                echo json_encode(Arr::flatten($leave_status));
            }else if($act == 'offJob'){
                $ding->_offJob();
            }else if($act == 'updateUser'){
                $res = $ding->_updateUser(
                    [
                        'userid' => '542706561157841',
                        'name' => '路章'
                    ]
                );
                print_r($res);
            }else if($act == 'workType'){//智能判断一天是否为法定工作日/法定休息日
                 $temp = DB::connection('proxy')->table('sniper_employee_ding_attendance')
                     ->select(DB::raw('`ymd`, count(1) as ct'))
                     ->where('checkType', 'OnDuty')
                     ->groupBy('ymd')
                     ->orderBy('ymd', 'asc')->get();
                $count = count($temp);
                for($i = 0; $i<$count; $i++){

                    if($i < 5){
                        $max = max([
                           $temp[0]->ct,
                           $temp[1]->ct,
                           $temp[2]->ct,
                           $temp[3]->ct,
                           $temp[4]->ct,
                           $temp[5]->ct,
                           $temp[6]->ct,
                           $temp[7]->ct,
                           $temp[8]->ct
                        ]);
                    }else if($i+4>=$count-1){
                        $max = max([
                            $temp[$count - 1]->ct,
                            $temp[$count - 2]->ct,
                            $temp[$count - 3]->ct,
                            $temp[$count - 4]->ct,
                            $temp[$count - 5]->ct,
                            $temp[$count - 6]->ct,
                            $temp[$count - 7]->ct,
                            $temp[$count - 8]->ct,
                            $temp[$count - 9]->ct,
                        ]);
                    }else{
                        $max = max([
                            $temp[$i - 4]->ct,
                            $temp[$i - 3]->ct,
                            $temp[$i - 2]->ct,
                            $temp[$i - 1]->ct,
                            $temp[$i]->ct,
                            $temp[$i + 1]->ct,
                            $temp[$i + 2]->ct,
                            $temp[$i + 3]->ct,
                            $temp[$i + 4]->ct
                        ]);
                    }
                    echo  $temp[$i]->ymd, ":", (100 * $temp[$i]->ct /$max) < 66;
                    if((100 * $temp[$i]->ct /$max) < 66){
                        Attendance::where('ymd', $temp[$i]->ymd)->update(['workType' => '0']);
                    }
                    echo "\n";
                }
            }else if($act == 'backupDepartment'){
                $departments = Department::all();
                $archive_id = DepartmentArchive::max('archive_id');
                $previousAll = DepartmentArchive::where('archive_id', $archive_id)->get();
                $archive_id++;
                foreach ($departments as $dept){
                    DepartmentArchive::create([
                        'archive_id' => $archive_id,
                        'id' => $dept->id,
                        'name' => $dept->name,
                        'manager' => $dept->manager,
                        'parent_id' => $dept->parent_id,
                        'left' => $dept->left,
                        'right' => $dept->right,
                        'depth' => $dept->depth
                    ]);
                }
                $srt = function($a, $b){
                    return $a->id - $b->id;
                };
                $currentAll = DepartmentArchive::where('archive_id', $archive_id)->get();
                $previousAll = $previousAll->sort($srt);
                $currentAll = $currentAll->sort($srt);
                $previousStr = '';
                $currentStr = '';
                foreach ($previousAll as $pa){
                    $previousStr .= implode('', [$pa->id, $pa->name, $pa->parent_id, $pa->left, $pa->right, $pa->depth]);
                }
                foreach ($currentAll as $pa){
                    $currentStr .= implode('', [$pa->id, $pa->name, $pa->parent_id, $pa->left, $pa->right, $pa->depth]);
                }
                if(md5($currentStr) == md5($previousStr)){
                    DepartmentArchive::where('archive_id', $archive_id)->delete();
                }
            }else if($act == 'lateNotice'){
                $month = date('Y-m');
                $yesterday = date('Y-m-d', strtotime('-1days'));
                $monthYesterday = date('Y-m', strtotime('-1days'));
                //忽略跨月份的情况
                if($month !== $monthYesterday){
                        return;
                }
                $allUsers = DB::connection('proxy')
                    ->table('sniper_employee_ding_users')
                    ->get();
                $userMap = [];
                foreach ($allUsers as &$user){
                    $user->email = $user->orgEmail;
                    $userMap[$user->userid] = $user;
                }
                $hitYesterdayUserIds = DB::connection('proxy')
                    ->table('sniper_employee_ding_attendance')
                    ->where('ymd', $yesterday)
                    ->where('timeResult', 'Late')
                    ->pluck('userid')
                    ->toArray();
                $hitThreeTimesUsers = DB::connection('proxy')
                    ->table('sniper_employee_ding_attendance')
                    ->where('ymd', 'like', "{$month}%")
                    ->where('timeResult', 'Late')
                    ->selectRaw('userId,count(1) as ct')
                    ->groupBy('userId')
                    ->having('ct', '>', 0)
                    ->get();
                foreach ($hitThreeTimesUsers as $user){
                    if(in_array($user->userId, $hitYesterdayUserIds)){
                        $user->name = $userMap[$user->userId]->name;
                        $lateNotice = new LateNotice($user);
                        Mail::to($user)->send($lateNotice);

                        try{
                            //same as ->with('employee.position.parent.employee.user')
                            $employee = User::where('email', $user->email)->first()->employee()->first()->position()->first()->parent()->first()->employee()->with('user')->get();
                            foreach($employee as $e){
                                $leader = new \stdClass();
                                $leader->name = $e->user->name;
                                $leader->email = $e->user->email;

                                $leader->memberName = $user->name;
                                $leader->memberCt = $user->ct;
                                $lateNoticeLeader = new LateNoticeLeader($leader);
                                Mail::to($leader)->send($lateNoticeLeader);
                            }
                        }catch (\Exception $e){
                            Log::info('invoke php artisan sniper:dingTalk lateNotice: '.$e->getMessage());
                            continue;
                        }

                    }
                }
            }else if($act == 'getUserAndDeptWeeklyAvgAttendanceForCache'){
                $_nthWeek = function ($day)
                {
                    $time = strtotime($day);
                    $wk_day = date('w', strtotime(date('Y-m-1 00:00:00', $time))) ? : 7; //今天周几
                    $d = date('d', $time) - (8 - $wk_day); //今天几号
                    return $d <= 0 ? 1 : ceil($d / 7) + 1;
                };

                $_weekWorkDay = function ($month)use($_nthWeek)
                {
                    $weekWorkDays = [];
                    $types = DingAttendance::select('ymd', 'workType')->where('ymd', 'like', $month.'%')->where('checkType', 'OffDuty')->groupBy('ymd')->groupBy('workType')->get()->toArray();
                    foreach ($types as $type){
                        $nth = $_nthWeek($type['ymd']);
                        if(!isset($weekWorkDays[$nth])){
                            $weekWorkDays[$nth] = 0;
                        }
                        $weekWorkDays[$nth] += $type['workType'];
                    }
                    return $weekWorkDays;
                };

                $_getLeaves = function ($userIds, $month)
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
                };
                $monthArr = [];
                for($i = 0; $i <= 9; $i++){
                    $monthArr[] = date('Y-m', strtotime("-{$i} months"));
                }
                $userIdArr = DB::connection('proxy')->table('sniper_employee_ding_users')->pluck('userid')->toArray();

                foreach ($userIdArr as $userId){
                    $user = DingUser::where('userid', $userId)->first();
                    if(!$user->hiredDate){
                        continue;
                    }
                    foreach ($monthArr as $month){
                            echo $user->department, ",";
                            echo $user->name, ",";
                            echo $month,",";
                            echo $userId, "\n";
                            if($user){
                                $hiredDate = intval($user->hiredDate / 1000);
                                if((strtotime($month) < $hiredDate) && date('Y-m', $hiredDate) !== $month){
                                    echo "雇佣日期：".date('Y-m-d', $hiredDate).",";
                                    echo "雇佣日期晚于本月,换人\n";
                                    break;
                                }
                            }
                            $department = $user->department;
                            $userIds = DB::connection('proxy')->table('sniper_employee_ding_users')->where('department', $department)->pluck('userid')->toArray();
                            $weekWorkDays = $_weekWorkDay($month);
                            $grp = [];

                            $attendances = DB::connection('proxy')->table('sniper_employee_ding_attendance')->where('ymd', 'like', $month.'%')->whereIn('userId', $userIds)->get();
                            foreach ($attendances as $at){
                                $grp[$at->userId][$at->ymd][] = $at->userCheckTime/1000;
                            }
                            $udt = [];
                            $leaves = $_getLeaves($userIds, $month);
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
                            foreach ($res as $r){
                                $weeklyAttendance = [
                                    'userId' => $userId,
                                    'name' => $user->name,
                                    'month' => $month,
                                    'week' => $r[0],
                                    'personal_hours' => $r[1],
                                    'department_hours' => $r[2],
                                    'department' => $user->department
                                ];
                                print_r($weeklyAttendance);
                                WeeklyAttendance::create($weeklyAttendance);
                                echo implode('--', $r);
                                echo "\n";
                            }
                        }
                }

                // select sum(personal_hours) as tt, count(1) as ct from sniper_employee_weekly_attendances where month = '2020-08' and week = '第2周' and personal_hours > 0;
                foreach ($monthArr as $month){
                    $weeks = DB::table('sniper_employee_weekly_attendances')->selectRaw('DISTINCT(`week`)')->where('month', $month)->pluck('week')->toArray();
                    foreach ($weeks as $week){
                        $total = DB::table('sniper_employee_weekly_attendances')->selectRaw('sum(`personal_hours`) as tt, count(1) as ct')->where('month', $month)->where('week', $week)->where('personal_hours', '>', 0)->first();
                        echo "{$month}-{$week}\n";
                        $avg = sprintf('%.2f', $total->tt / $total->ct);
                        print_r($avg);
                        echo "\n";
                        DB::table('sniper_employee_weekly_attendances')->where('month', $month)->where('week', $week)->update(['company_hours' => $avg]);
                    }
                }
            }else if($act == 'deptToPosition'){
                    Position::truncate();
                    $departments = Department::all();
                    foreach ($departments as $department){
                        if($department->id == 1){
                            $positionName = '总经理';
                        }else{
                            $positionName = $department->name . '主管';
                        }
                        Position::create(['name' => $positionName, 'department_id' => $department->id]);
                    }
                    foreach ($departments as $department){
                        $deptPosition = Position::where('department_id', $department->id)->first();
                        $existingParentDept = Position::where('department_id', $department->parent_id)->first();
                        if($existingParentDept){
                            $deptPosition->makeChildOf($existingParentDept);
                        }else{
                            $deptPosition->makeRoot();
                        }
                    }

                $dingUsers = DB::connection('proxy')->table('sniper_employee_ding_users')->get();
                foreach ($dingUsers as $du){
                    if($du->isLeaderInDepts == 1){
                        $userid = $du->userid;
                        $department = $du->department;
                        $position = Position::where('department_id', $department)->first();
                        $employee = Employee::where('userid', $userid)->first();
                        $employee->position_id = $position->id;
                        $employee->save();
                    }
                }
            }
/*else if($act == 'workTime'){
                $month = '2020-09';
                $weekWorkDays = [];
                $types = Attendance::select('ymd', 'workType')->where('ymd', 'like', $month.'%')->groupBy('ymd')->groupBy('workType')->get()->toArray();
                foreach ($types as $type){
                    $nth = $this->_nthWeek($type['ymd']);
                    if(!isset($weekWorkDays[$nth])){
                        $weekWorkDays[$nth] = 0;
                    }
                    $weekWorkDays[$nth] += $type['workType'];
                }
                $grp = [];

                $attendances = Attendance::where('ymd', 'like', $month.'%')->get();
                foreach ($attendances as $at){
                    $grp[$at->userId][$at->ymd][] = $at->userCheckTime/1000;
                }
                $udt = [];
                foreach ($grp as $userId => $daily){
                    foreach ($daily as $day => $data){
                        if(isset($data[0]) && isset($data[1])) {
                            $udt[$userId][$this->_nthWeek($day)][$day] = abs($data[1] - $data[0]);
                        }
                    }
                }
                $lastArr = [];
                foreach ($udt as $userId => $data){
                    foreach ($data as $nth => $val){
                        $lastArr[$userId][$nth] = array_sum($val) / ($weekWorkDays[$nth] * 60 * 60);
                    }
                }
                print_r($lastArr);
            }*/
    }
}
