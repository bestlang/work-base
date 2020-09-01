<?php
namespace Bestlang\Laracms\Events;

use Illuminate\Queue\SerializesModels;


class PayNotify
{
    use SerializesModels;
    
    public $order_no;

    public function __construct($order_no)
    {
        $this->order_no = $order_no;
    }

}