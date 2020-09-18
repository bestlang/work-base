<?php

namespace Sniper\Employee\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Sniper\Employee\Services\DingTalk;
use Sniper\Employee\Models\User;
use Sniper\Employee\Models\DingTalk\User as DingUser;

class ProcessEditUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $signal;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($signal)
    {
        $this->signal = $signal;
    }

    /**
     * Execute the job.
     * @param DingTalk $ding
     * @return void
     */
    public function handle(DingTalk $ding)
    {
        $map = [
            'C' => '_createUser',
            'U' => '_updateUser',
            'D' => '_deleteUser'
        ];
        $user_id = substr($this->signal, 0, -1);
        $act = substr($this->signal, -1);
        $user = User::with(['dingUser'])->find($user_id);
        if($act == 'U'){
            $attr = [
                'userid' => $user->dingUser->userid,
                'name' => $user->name,
                'email' => $user->email,
                'orgEmail' => $user->email,
                'tel' => $user->phone
            ];
            $ding->_updateUser($user_id, $attr);
        }
        //$ding->${$map[$act]}($user_id, []);

    }
}
