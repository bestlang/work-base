<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cms\Model as CmsModel;

class Content extends Model
{
    protected $table = 'cms_contents';
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function contents()
    {
        return $this->hasMany(ContentContent::class);
    }

    public function metas()
    {
        return $this->hasMany(ContentMeta::class);
    }

    public function model()
    {
        return $this->belongsTo(CmsModel::class);
    }
}
