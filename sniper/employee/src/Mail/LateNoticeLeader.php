<?php

namespace Sniper\Employee\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LateNoticeLeader extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * LateNotice constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = env('MAIL_USERNAME');
        return $this->from($from,'组员考勤报告')
            ->subject('组员迟到提醒')
            ->view('employee::emails.lateNoticeLeader');
    }
}
