<?php

namespace Sniper\Employee\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LateNotice extends Mailable
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
        return $this->from($from,'考勤报告')
                            ->subject('迟到提醒')
                            ->view('employee::emails.lateNotice');
    }
}
