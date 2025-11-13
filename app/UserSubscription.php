<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $fillable = [
        'order_id', 'subscription_id','user_id','subscription_name','start_date','status'
    ];
    protected $table = 'user_subscription';

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    function getNextSubscriptionBillingDate($numberOfCycles = 1) {

        $startDate = strtotime($this->start_date);

        $currentMonth = date('m', $startDate);

        $nextMonth = (($currentMonth + $numberOfCycles) % 12);
        if ($nextMonth === 0) {
            $nextMonth = 12;
        }

        $targetDate = new \DateTime();
        $targetDate->setTimestamp($startDate);

        $targetDate->add(new \DateInterval('P' . $numberOfCycles . 'M'));
        while ((int)$targetDate->format('m') !== $nextMonth) {
            $targetDate->sub(new \DateInterval('P1D'));
        }

        return $targetDate->format('Y-m-d');

    }
}
