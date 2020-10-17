<?php

namespace BestLang\Laracms\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class ModelField extends Model
{
    protected $table = 'cms_model_fields';
    protected $guarded = [];

    public function setExtraAttribute($value)
    {
        $this->attributes['extra'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getExtraAttribute($value){
        return json_decode($value);
    }
}
