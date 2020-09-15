<?php

namespace Sniper\Employee\Console\Commands;

use Illuminate\Console\Command;
use Sniper\Employee\Services\DingTalk;

class GetDingUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sniper:employee:getDingUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get all users from alibaba dingtalk';

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
     * @param DingTalk $dingTalk
     */
    public function handle(DingTalk $dingTalk)
    {
            $departments = $dingTalk->departments();
            $departmentIds = $departments['departmentIds'];
            foreach ($departmentIds as $departmentId){
                echo json_encode($dingTalk->_getDepartmentUsers($departmentId));
                echo "===================================\n";
            }
    }
}
