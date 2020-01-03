<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'email', 'password', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mp' => 'array'
    ];

    /* newly add code */
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

//    public function getMpAttribute($value)
//    {
//        return $value;
//    }

    public function searchHistories()
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function moneyRecords()
    {
        return $this->hasMany(UserMoney::class);
    }

    public function collectGoods()
    {
        return $this->hasMany(CollectGoods::class);
    }

    public function visitHistories()
    {
        return $this->hasMany(VisitHistory::class);
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }

    public function activityTuanOrders()
    {
        return $this->hasMany(ActivityTuanOrder::class);
    }
}
