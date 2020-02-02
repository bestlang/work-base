<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'cms_contents';
    protected $guarded = [];

    public function contents()
    {
        return $this->hasMany(ContentContent::class);
    }
}
