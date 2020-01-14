<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class ModelField extends Model
{
    protected $table = 'cms_model_fields';
    protected $fillable = ['type', 'field', 'label', 'extra', 'is_channel'];
}
