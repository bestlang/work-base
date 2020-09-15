<?php

namespace Sniper\Employee\Console\Commands;

use Illuminate\Console\Command;
use Sniper\Employee\Services\DingTalk as DingService;
use Arr;
use Sniper\Employee\Models\DingTalk\Attendance;

class DingTalk extends Command
{
    /**
     * The name and signature of the console command.
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
                echo json_encode($allUsers);
            }else if($act == 'departments'){
                $departments = $ding->departments();
                echo json_encode($departments);
            }else if($act == 'attendance'){
                $allAttendance = [];

                $startTimestamp = strtotime('-5 days');
                $workDateTo = date('Y-m-d H:i:s', $startTimestamp+ 5 * 86400 );
//                while($startTimestamp < time()){
                    $workDateFrom = date('Y-m-d H:i:s', $startTimestamp);
                    $offset = 0;
                    $limit = 50;
                    while($attendances = $ding->_getUserAttendance(["0264283157756536"], $workDateFrom, $workDateTo, $offset, $limit)){
                        $allAttendance[] = $attendances;
                        foreach ($attendances as $att){
                            echo json_encode($att),"\n";
                            Attendance::updateOrCreate(
                                ['id' => $att->id],
                                [
                                "baseCheckTime" => $att->baseCheckTime,
                                "checkType" => $att->checkType,
                                "corpId" => $att->corpId,
                                "groupId" => $att->groupId,
                                "locationResult" => $att->locationResult,
                                "planId" => $att->planId,
                                "recordId" => $att->recordId,
                                "timeResult" => $att->timeResult,
                                "userCheckTime" => $att->userCheckTime,
                                "userId" => $att->userId,
                                "workDate" => $att->workDate,
                                "procInstId" => $att->procInstId
                            ]);
                        }
                        $offset += $limit;
                        usleep(100);
                    }
//                    $startTimestamp += 5 * 86400;
//                }
            }

    }
}
