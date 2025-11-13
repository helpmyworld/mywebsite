<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    protected $fillable = [
        'title', 'image','price','capacity'
    ];

    public function capacities ()
    {
        return $this->belongsToMany('App\Capacity', 'host_capacity', 'host_id', 'capacity_id');
    }
}
