<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'title', 'image','price','benefit'
    ];

    public function benefits()
    {
        return $this->belongsToMany('App\Benefit', 'subscription_benefit', 'subscription_id', 'benefit_id');
    }
}
