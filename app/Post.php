<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    protected $fillable = [
        'title','body','image','user_id','type','admin_id',
    ];
    //
    public function tags()
    {
       
        return $this->belongsToMany('App\Tag');
    }
    
    public function cats()
    {
        //
        return $this->belongsToMany('App\Cat');
    }


//    public function admin() //posts belong to the user
//    {
//        //
//        return $this->belongsTo(Admin::class);
//
//
//    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function admin()
    {
        return $this->belongsTo('App\Admin','admin_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }


     use Sluggable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
