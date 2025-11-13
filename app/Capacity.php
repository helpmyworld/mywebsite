<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
{
    protected $fillable = [
        'name',
    ];

    public function capacity ()
    {
        return $this->belongsToMany('App\Host', 'host_capacity', 'capacity_id', 'host_id');
    }
}
