<?php

namespace BestLang\LaraCms\Console\Commands;

use Illuminate\Console\Command;
class LaraCms extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'LaraCms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LaraCms,install';

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
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => 'BestLang\Base\Providers\AppServiceProvider', '--force' => true]);
        $this->call('vendor:publish', ['--provider' => 'BestLang\LaraCms\Providers\AppServiceProvider']);
        $this->call('vendor:publish', ['--provider' => 'BestLang\LaravelUEditor\UEditorServiceProvider']);
        $this->call('vendor:publish', ['--provider' => 'BestLang\WxPay\WxPayServiceProvider']);
        $this->call('vendor:publish', ['--provider' => 'Alipay\EasySDK\Providers\AliPayServiceProvider']);
        $this->call('vendor:publish', ['--provider' => 'Sniper\Employee\Providers\AppServiceProvider']);
        $this->call('migrate');
        $this->call('db:seed',['--class' => 'BestLangBaseSeeder']);
        $this->call('db:seed',['--class' => 'LaraCmsSeeder']);
        $this->call('db:seed',['--class' => 'SniperSeeder']);
    }
}
