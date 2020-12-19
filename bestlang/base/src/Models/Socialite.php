<?php

namespace BestLang\Base\Models;

use Illuminate\Database\Eloquent\Model;

class Socialite extends Model
{
    protected $table = 'socialite';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
