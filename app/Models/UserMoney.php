<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMoney extends Model
{
    //
    protected $table = 'user_money';
    protected $guarded = [];

    public function contributer()
    {
        return $this->belongsTo(User::class, 'contributer_id', 'id');
    }
}
