<?php

namespace Sniper\Employee\Console\Commands;

use Illuminate\Console\Command;
use Sniper\Employee\Models\DingTalk\Leave;
use Sniper\Employee\Models\User;
use Sniper\Employee\Services\DingTalk as DingService;
use Arr;
use Sniper\Employee\Models\DingTalk\Attendance;
use Sniper\Employee\Models\DingTalk\Department as DingDepartment;
use Sniper\Employee\Models\Department;
use Sniper\Employee\Models\DingTalk\User as DingUser;
use DB;

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
                            'isLeaderInDepts' => $user->isLeaderInDepts,
                            'isBoss' => $user->isBoss,
                            'hiredDate' => isset($user->hiredDate) ? $user->hiredDate : '',
                            'isSenior' => $user->isSenior,
                            'tel' => isset($user->tel) ? $user->tel : '',
                            'department' => $user->department[0],
                            'workPlace' => isset($user->workPlace) ? $user->workPlace : '',
                            'email' => isset($user->email) ? $user->email : '',
                            'orgEmail' => isset($user->orgEmail) ? $user->orgEmail : '',
                            'orderInDepts' => $user->orderInDepts,
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
            }else if($act == 'syncUsers'){
                $dingUsers = DingUser::all();
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
                            'avatar' => $dingUser->avatar
                            //'position_id' => null,
                            //'phone' => null,
                            //'gender' => null,
                            //'id_card' => null,
                            //'avatar' => null,
                            //扩展信息
                        ]);
                    }else if($user && !$user->emplyee){
                        $user->employee()->create([
                            'real_name' => $dingUser->name,
                            'department_id' => $dingUser->department,//使用dingTalk自带的department编号插入
                            'avatar' => $dingUser->avatar
                        ]);
                    }else{
                        $user->employee->real_name = $dingUser->name;
                        $user->employee->department_id = $dingUser->department;
                        $user->employee->avatar = $dingUser->avatar;
                        $user->push();
                    }
                }
            }else if($act == 'attendance'){
                $dateBegin = date('Y-m-d 00:00:00');
                for($days = 0; $days<90; $days++){
                    $workDateFrom = date('Y-m-d H:i:s',strtotime($dateBegin) - $days * 86400);
                    $workDateTo = date('Y-m-d H:i:s',strtotime($workDateFrom) + 86400);
                    $userIds = DB::connection('proxy')->table('sniper_employee_ding_users')->pluck('userid')->toArray();
                    echo "\n--------------------------query {$workDateFrom}-------------------------:\n";
                    $offset = 0;
                    $limit = 50;
                    while($attendances = $ding->_getUserAttendance($userIds, $workDateFrom, $workDateTo, $offset, $limit)){
                        foreach ($attendances as $att){
                            echo json_encode($att),"\n";
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
            }else if($act == 'leavestatus'){
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
                    Leave::updateOrCreate([
                        'userid' => $leave->userid,
                        'start_time' => $leave->start_time
                    ],[
                        'end_time' => $leave->end_time
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
            }
//            else if($act == 'test'){
//                $leaves = DingDepartment::with('subs')->get()->filter(function($dep){
//                    return !count($dep->subs);
//                });
//                print_r($leaves->toArray());
//                $depMap = [];
//                DB::connection('proxy')->table('sniper_employee_ding_users')->get()->each(function($user)use(&$depMap){
//                    $depMap[$user->userid] = $user->department;
//                });
//                print_r($depMap);
//            }
            else if($act == 'workType'){//智能判断一天是否为法定工作日/法定休息日
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
            }
//else if($act == 'workTime'){
//                $month = '2020-09';
//                $weekWorkDays = [];
//                $types = Attendance::select('ymd', 'workType')->where('ymd', 'like', $month.'%')->groupBy('ymd')->groupBy('workType')->get()->toArray();
//                foreach ($types as $type){
//                    $nth = $this->_nthWeek($type['ymd']);
//                    if(!isset($weekWorkDays[$nth])){
//                        $weekWorkDays[$nth] = 0;
//                    }
//                    $weekWorkDays[$nth] += $type['workType'];
//                }
//                $grp = [];
//
//                $attendances = Attendance::where('ymd', 'like', $month.'%')->get();
//                foreach ($attendances as $at){
//                    $grp[$at->userId][$at->ymd][] = $at->userCheckTime/1000;
//                }
//                $udt = [];
//                foreach ($grp as $userId => $daily){
//                    foreach ($daily as $day => $data){
//                        if(isset($data[0]) && isset($data[1])) {
//                            $udt[$userId][$this->_nthWeek($day)][$day] = abs($data[1] - $data[0]);
//                        }
//                    }
//                }
//                $lastArr = [];
//                foreach ($udt as $userId => $data){
//                    foreach ($data as $nth => $val){
//                        $lastArr[$userId][$nth] = array_sum($val) / ($weekWorkDays[$nth] * 60 * 60);
//                    }
//                }
//                print_r($lastArr);
//            }
    }
}
