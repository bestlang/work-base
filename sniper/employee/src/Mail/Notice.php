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
       $this->from($from,'公告');
        $this->subject($this->notice->title);
        foreach (json_decode($this->notice->attachments) as $at){
            $this->attach($at->url);
        }
        return $this->view('sniper::emails.notice');
    }
}
