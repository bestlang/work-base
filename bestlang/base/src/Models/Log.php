<?php

namespace BestLang\Base\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    public $guarded = [];

    public static function write($level, $content)
    {
        self::create(compact(['level', 'content']));
    }
}
