<?php

namespace Sniper\Employee\Console\Commands;

use Illuminate\Console\Command;
use Sniper\Employee\Services\DingTalk as DingService;
use Arr;

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
                $offset = 0;
                $limit = 50;
                while($attendance = $ding->_getUserAttendance(['0264283157756536'], $offset, $limit)){
                    $allAttendance[] = $attendance;
                    echo json_encode($attendance);
                    $offset += $limit;
                }
            }

    }
}
