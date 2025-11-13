<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'name',
    ];

    public function websites()
    {
        return $this->belongsToMany('App\Website', 'website_work', 'work_id', 'website_id');
    }
}
