<?php

namespace Sniper\Employee\Models\DingTalk;

use Illuminate\Database\Eloquent\Model;
class Leave extends Model
{
    protected $connection = 'proxy';
    protected $table = 'sniper_employee_ding_leave';
    protected $guarded = [];
}