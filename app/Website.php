<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'title', 'image','price','work'
    ];

    public function works()
    {
        return $this->belongsToMany('App\Work', 'website_work', 'website_id', 'work_id');
    }
}
