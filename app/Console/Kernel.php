<?php

namespace App\Console;

use App\Console\Commands\GenSql;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Apis\Pdd;
use App\Pdd\PddOrder;
use App\Console\Commands\PddCats;
use App\Apis\Mp;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
//        PddCats::class,
        GenSql::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        ///////////////////////////////////////////////////
//        // 抓取成交的订单
//        $schedule->call(function () {
//            $pdd = new Pdd();
//            $result = $pdd->orderListRangeGet();
//        })->everyMinute();
//        ///////////////////////////////////////////////////
//
//        ///////////////////////////////////////////////////
//        // 更新已经成交订单的状态并计算到收益表
//        $schedule->call(function () {
//            $pdd = new Pdd();
//            $todo_orders = PddOrder::get();
//            if(count($todo_orders)){
//                foreach ($todo_orders as $order){
//                    // 分发收益
//                    $pdd->orderProfitDispatch($order);
//                }
//            }
//        })->hourly();
//        ///////////////////////////////////////////////////
//
//        ///////////////////////////////////////////////////
//        //更新小程序accessToken
        $schedule->command('sniper:dingTalk  attendance')->hourly();
//        ///////////////////////////////////////////////////
//
//        ///////////////////////////////////////////////////
//        $schedule->call(function () {
//            $mp = new Mp();
//
//            $path = "/images/sflxzs.jpeg";
//            $media_id = $mp->csImage($path);//
//            Cache::put('xzs_access_token', $media_id, 5*24*60*60);
//
//            $path = "/images/sflfwh.jpg";
//            $media_id = $mp->csImage($path);//
//            Cache::put('fwh_access_token', $media_id, 5*24*60*60);
//
//            //修改stoarge权限
//            exec("chmod -R 777 ".storage_path());
//        })->dailyAt('05:00');
//        ///////////////////////////////////////////////////
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
