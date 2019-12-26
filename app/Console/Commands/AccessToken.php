<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Apis\Mp;
use Illuminate\Support\Facades\Cache;

class AccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'access:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get wechat mp access_token';

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
        $mp = new Mp();
        $res = $mp->refreshAccessToken();
        Cache::put('access_token', $res->access_token, 7200);
        exec("chmod -R 777 ".storage_path());
    }
}
