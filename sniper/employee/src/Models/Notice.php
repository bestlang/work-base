<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'sniper_employee_notices';
    protected $guarded = [];

    public function audiences()
    {
        return $this->belongsToMany(User::class, 'sniper_employee_notice_audiences', 'notice_id', 'user_id')
            ->using(NoticeAudience::class);
    }
}
