<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Admin as Authenticatable;

class Admin extends Model
{
//    protected $fillable = [
//        'username',  'password',
//    ];
//
//    /**
//     * The attributes that should be hidden for arrays.
//     *
//     * @var array
//     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];


    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function posts()
    {
        return $this->hasMany('App\Post','admin_id');
    }


    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function scopeAuthors($query)
    {
        return $query->where('role_id',2);
    }
}
