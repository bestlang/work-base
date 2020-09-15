<?php

namespace Sniper\Employee\Models\DingTalk;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'sniper_employee_ding_attendance';
    protected $guarded = [];
    protected $connection = 'proxy';

}
