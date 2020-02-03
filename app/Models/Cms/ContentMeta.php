<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class ContentMeta extends Model
{
    protected $table = 'cms_content_metas';
    protected $guarded = [];
    public $timestamps = false;
}
