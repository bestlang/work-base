<?php
namespace BestLang\Base\Events;

use Illuminate\Queue\SerializesModels;
use BestLang\Base\Models\History;

class HistoryEvent{

    use SerializesModels;

    public $history;

    public function __construct(History $history)
    {
        $this->history = $history;
    }
}