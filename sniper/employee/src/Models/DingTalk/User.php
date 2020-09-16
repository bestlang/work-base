<?php
namespace Sniper\Employee\Models\DingTalk;

use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $connection = 'proxy';
    protected $table = 'sniper_employee_ding_users';
    protected $guarded = [];

    protected $primaryKey = 'userid';
}