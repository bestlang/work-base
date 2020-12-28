<?php

namespace Sniper\Employee\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Sniper\Employee\Models\Notice;
use Sniper\Employee\Mail\Notice as NoticeMailable;
use Mail;

class ProcessNotice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $notice;

    /**
     * ProcessNotice constructor.
     * @param Notice $notice
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notice = $this->notice;
        foreach ($notice->audiences as $audience){
            print_r($audience->toArray());
            $n = new NoticeMailable($notice);
            try {
                Mail::to($audience)->send($n);
            }catch (\Exception $e){
                echo "error occur\n";
                echo $e->getMessage();
            }
        }
    }
}
