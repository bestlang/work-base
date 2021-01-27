<?php

namespace BestLang\LaraCMS\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    protected $table = 'cms_field_types';
    protected $guarded = [];
    public $timestamps = false;

    public function setExtraAttribute($value)
    {
        $this->attributes['extra'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getExtraAttribute($value){
        return json_decode($value);
    }
}
