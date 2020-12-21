<?php

namespace Sniper\Employee\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sniper\Employee\Models\Notice as NoticeModel;

class Notice extends Mailable
{
    use Queueable, SerializesModels;
    public $notice;

    /**
     * Notice constructor.
     * @param NoticeModel $notice
     */
    public function __construct(NoticeModel $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = env('MAIL_USERNAME');
        return $this->from($from,'公告')
            ->subject('123')//$this->notice->title
            ->view('sniper::emails.notice');
            //->attach(json_decode($this->notice->attachments));
//
//        $from = env('MAIL_USERNAME');
//        return $this->from($from,'组员考勤报告')
//            ->subject('组员迟到提醒')
//            ->view('sniper::emails.lateNoticeLeader');
    }
}
