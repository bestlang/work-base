<?php

namespace Sniper\Employee\Console\Commands;

use Illuminate\Console\Command;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            echo $this->description;
    }
}
