<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NoticeAudience extends Pivot
{
    protected $table = 'sniper_employee_notice_audiences';
    protected $guarded = [];
    public $incrementing = true;
}
