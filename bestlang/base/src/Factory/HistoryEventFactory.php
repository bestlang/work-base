<?php
namespace BestLang\Base\Factory;

use BestLang\Base\Models\History;
use BestLang\Base\Events\HistoryEvent;

class HistoryEventFactory
{
    public static function loginEvent()
    {
        $history = new History();
        $history->user_id = auth()->user()->id;
        $history->action = '登录';
        $history->ip = request()->ip();
        return new HistoryEvent($history);
    }

    public static function logoutEvent()
    {
        $history = new History();
        $history->user_id = auth()->user()->id;
        $history->action = '登出';
        $history->ip = request()->ip();
        return new HistoryEvent($history);
    }
}