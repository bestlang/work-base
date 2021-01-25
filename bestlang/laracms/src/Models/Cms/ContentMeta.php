<?php

namespace BestLang\LaraCMS\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class ContentMeta extends Model
{
    protected $table = 'cms_content_metas';
    protected $guarded = [];
    public $timestamps = false;

//    public function getValueAttribute($value)
//    {
//        $decode = json_decode($value);
//        if(!$decode){
//            return $value;
//        }
//        return $decode;
//    }
}
