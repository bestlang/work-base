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
        foreach ($dingSubs as $dingSub){
            $child = Department::updateOrCreate(['id' => $dingSub->id, 'name' => $dingSub->name]);
            $child->makeChildOf($parent);
            if($dingSub->subs){
                $this->_syncDepartments($child, $dingSub->subs);
            }
        }
    }
    /**
     * @param DingService $ding
     */
    public function handle(DingService $ding)
    {
            $act = $this->argument('act');
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
                            'department_id' => $dingUser->department,
                            'avatar' => $dingUser->avatar
                            //'position_id' => null,
                            //'phone' => null,
                            //'gender' => null,
                            //'id_card' => null,
                            //'avatar' => null,
                            //扩展信息
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
                for($days = 0; $days<180; $days++){
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
                        //usleep(100);
                    }
                    //usleep(200);
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
            }
    }
}
