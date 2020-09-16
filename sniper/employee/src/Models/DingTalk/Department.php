<?php
namespace Sniper\Employee\Models\DingTalk;

use Illuminate\Database\Eloquent\Model;
class Department extends Model
{
    protected $connection = 'proxy';
    protected $table = 'sniper_employee_ding_departments';
    protected $guarded = [];

}