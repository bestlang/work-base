<?php

namespace BestLang\LaraCMS\Console\Commands;

use Illuminate\Console\Command;
class LaraCMS extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'LaraCMS:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LaraCMS:install';

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
        $this->call('vendor:publish', ['--provider' => 'BestLang\LaraCMS\Providers\AppServiceProvider']);
        $this->call('vendor:publish', ['--provider' => 'BestLang\LaravelUEditor\UEditorServiceProvider']);
        $this->call('vendor:publish', ['--provider' => 'BestLang\WxPay\WxPayServiceProvider']);
        $this->call('vendor:publish', ['--provider' => 'Alipay\EasySDK\Providers\AliPayServiceProvider']);
        $this->call('migrate');
        $this->call('db:seed',['--class' => 'BestLangBaseSeeder']);
        $this->call('db:seed',['--class' => 'LaraCMSSeeder']);
    }
}
