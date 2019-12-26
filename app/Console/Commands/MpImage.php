<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Apis\Mp;
use App\User;

class MpImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mp:image {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate mp code image for each individual mp user';

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
        $force = $this->option('force');
        if(is_null($force)){
            $force = false;
        }else{
            $force = true;
        }
        $mp = new Mp();
        User::chunk(200, function ($users) use($mp, $force){
            foreach ($users as $user) {
                $mp->genMpImage($user->id, $force);
//                if($user->mp){
//                    $openid = $user->mp['openid'];
//                    $mp->genMpImage($openid, $force);
//                }
            }
        });
    }
}
