<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token', 'wechat_token', 'qq_token',
    ];

    /**
     * 当用户没有头像的时候，返回gravatar
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if (empty(trim($value))) {
            return Gravatar::src($this->email);
        }
        return $value;
    }

    public function order()
    {
        return $this->hasMany('App\OrderModel', 'user_id', 'id');
    }

    public function host()
    {
        return $this->hasMany('App\HostModel', 'user_id', 'id');
    }

    public function workOrder()
    {
        return $this->hasMany('App\WorkOrderModel', 'user_id', 'id');
    }
}
