<?php

namespace Bestlang\Base\Models;

use Illuminate\Database\Eloquent\Model;

class HashConfig extends Model
{
    protected $table = 'hash_config';
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
