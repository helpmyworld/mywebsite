<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    protected $fillable = [
        'name',
    ];

    public function subscriptions()
    {
        return $this->belongsToMany('App\Subscription', 'subscription_benefit', 'benefit_id', 'subscription_id');
    }
}
