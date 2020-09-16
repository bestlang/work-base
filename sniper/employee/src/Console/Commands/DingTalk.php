<?php

namespace Sniper\Employee\Console\Commands;

use Illuminate\Console\Command;
use Sniper\Employee\Services\DingTalk as DingService;
use Arr;
use Sniper\Employee\Models\DingTalk\Attendance;
use Sniper\Employee\Models\DingTalk\Department as DingDepartment;
use Sniper\Employee\Models\DingTalk\User as DingUser;

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
                        DingUser::updateOrCreate(['userid' => $user->userid],[
                            'errcode' => $user->errcode,
                            'unionid' => $user->unionid,
                            'openId' =>$user->openId,
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
            }else if($act == 'attendance'){
                $dateBegin = date('Y-m-d 00:00:00');
                for($days = 0; $days<180; $days++){
                    $workDateFrom = date('Y-m-d H:i:s',strtotime($dateBegin) - $days * 86400);
                    $workDateTo = date('Y-m-d H:i:s',strtotime($workDateFrom) + 86400);
                    $userIds = DingUser::all()->map(function($user){
                        return $user->userid;
                    })->toArray();
                    echo "\n--------------------------query {$workDateFrom}-------------------------:\n";
                    $offset = 0;
                    $limit = 50;
                    while($attendances = $ding->_getUserAttendance($userIds, $workDateFrom, $workDateTo, $offset, $limit)){
                        foreach ($attendances as $att){
                            echo json_encode($att),"\n";
                            Attendance::updateOrCreate(
                                ['userId' => $att->userId,"workDate" => $att->workDate, "ymd" => date('Y-m-d',$att->baseCheckTime / 1000), "checkType" => $att->checkType,],
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
                                    "procInstId" => isset($att->procInstId) ? $att->procInstId : ''
                                ]);
                        }
                        $offset += $limit;
                        usleep(100);
                    }
                    usleep(200);
                }

            }
    }
}
