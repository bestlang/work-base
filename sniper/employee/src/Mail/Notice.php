<?php

namespace Sniper\Employee\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Notice extends Mailable
{
    use Queueable, SerializesModels;
    public $notice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notice)
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
            ->subject($this->notice->title)
            ->view('sniper::emails.notice');
            //->attach(json_decode($this->notice->attachments));
    }
}
