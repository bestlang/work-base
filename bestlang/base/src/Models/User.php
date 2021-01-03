<?php

namespace BestLang\Base\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use BestLang\Base\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use BestLang\Base\Events\ModelCreatedEvent;
use BestLang\Base\Events\ModelDeletedEvent;
use BestLang\Base\Events\ModelUpdatedEvent;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,HasRoles;

    protected $dispatchesEvents = [
        'created' => ModelCreatedEvent::class,
        'deleted' => ModelDeletedEvent::class,
        'updated' => ModelUpdatedEvent::class
    ];

    protected $appends = ['type'];

    //https://docs.spatie.be/laravel-permission/v2/basic-usage/multiple-guards/#main
    protected $guard_name = 'api';

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


    public function getTypeAttribute()
    {
        return self::roles()->get()->some(function($role){
            return $role->id > 0;
        }) ? 1 : 0;
    }
}
