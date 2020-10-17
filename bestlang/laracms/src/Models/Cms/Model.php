<?php

namespace BestLang\Laracms\Models\Cms;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    protected $table = 'cms_models';

    protected $fillable = [
        'name',
        'template_prefix'
    ];

    public function fields()
    {
        return $this->hasMany(ModelField::class)->orderBy('order_factor', 'asc');
    }

    public function channels()
    {
        return $this->hasMany(Channel::class)->orderBy('order_factor', 'asc');
    }
}
