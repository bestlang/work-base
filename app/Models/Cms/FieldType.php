<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    protected $table = 'cms_field_types';
    protected $fillable = ['type', 'name'];
    public $timestamps = false;
}
