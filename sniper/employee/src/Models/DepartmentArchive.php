<?php

namespace Sniper\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentArchive extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    protected $table = 'sniper_employee_departments_archive';
    protected $guarded = [];

//    public function parent()
//    {
//        return $this->belongsTo(DepartmentArchive::class, 'parent_id')->where('archive_id', $this->attributes['archive_id']);
//    }
//
//    public function children()
//    {
//        return $this->hasMany(DepartmentArchive::class, 'parent_id')->where('archive_id', $this->attributes['archive_id']);
//    }
}
