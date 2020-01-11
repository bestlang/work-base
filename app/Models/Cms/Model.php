<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    protected $table = 'cms_models';

    protected $fillable = [
        'name',
        'channel_template_prefix',
        'content_template_prefix'
    ];
}
