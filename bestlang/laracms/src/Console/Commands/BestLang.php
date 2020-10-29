<?php

namespace BestLang\Laracms\Console\Commands;

use Illuminate\Console\Command;
use Arr;
use DB;

class BestLang extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'BestLang:install';

    /**
     * The console command description.
     */
    protected $description = 'BestLang,install';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->call('vendor:publish', ['--provider'=>'BestLang\Base\Providers\AppServiceProvider', '--force'=>true]);
        $this->call('vendor:publish', ['--provider'=>'BestLang\Laracms\Providers\AppServiceProvider']);
        $this->call('vendor:publish', ['--provider'=>'BestLang\LaravelUEditor\UEditorServiceProvider']);
        $this->call('vendor:publish', ['--provider'=>'BestLang\WxPay\WxPayServiceProvider']);
        $this->call('vendor:publish', ['--provider'=>'Sniper\Employee\Providers\AppServiceProvider']);
        $this->call('migrate');
        $this->call('db:seed', ['--class'=>'BestLangBaseSeeder']);
        $this->call('db:seed', ['--class'=>'LaraCmsSeeder']);
        $this->call('db:seed', ['--class'=>'SniperSeeder']);
    }
}
