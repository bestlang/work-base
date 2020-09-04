<?php

namespace Bestlang\Laracms\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class DeprecatedConfig extends Model
{
    protected $table = 'cms_config';
    public $guarded = [];

    public static function get($key, $field)
    {
        $config = self::where(['key'=>$key, 'field'=>$field])->first();
        return $config->value;
    }

    public static function set($key, $field, $value)
    {
        $config = self::where(['key'=>$key, 'field'=>$field])->first();
        if($config){
            $config->value = $value;
            $config->save();
        }
    }
}
