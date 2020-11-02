<?php
namespace BestLang\Base\Factory;

use BestLang\Base\Models\History;
use BestLang\Base\Events\HistoryEvent;

class HistoryEventFactory
{
    public static function loginEvent()
    {
        $history = new History();
        $history->action = '登录';
        return new HistoryEvent($history);
    }

    public static function logoutEvent()
    {
        $history = new History();
        $history->action = '登出';
        return new HistoryEvent($history);
    }

    public static function operationEvent($action='')
    {
        $history = new History();
        $history->action = $action;
        return new HistoryEvent($history);
    }
}