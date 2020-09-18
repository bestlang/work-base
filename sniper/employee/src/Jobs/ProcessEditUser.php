<?php

namespace Sniper\Employee\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Sniper\Employee\Services\DingTalk;
use Sniper\Employee\Models\DingTalk\User as DingUser;

class ProcessEditUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    protected $signal;
    protected $attr;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($signal, $attr)
    {
        $this->signal = $signal;
        $this->attr = $attr;
    }

    /**
     * Execute the job.
     * @param DingTalk $ding
     * @return void
     */
    public function handle(DingTalk $ding)
    {
        if($this->signal == 'U'){
            $res = $ding->_updateUser($this->attr);
            echo json_encode($this->attr),"\n";
            echo json_encode($res),"\n";
        }
        //$ding->${$map[$act]}($user_id, []);

    }
}
