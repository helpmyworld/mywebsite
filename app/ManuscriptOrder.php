<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ManuscriptOrder extends Model
{
    protected $fillable = [
        'user_id','manuscript_id','billing_name', 'billing_street_address','billing_city','billing_suburb','billing_state','billing_country','billing_postcode','billing_phone',
        'shipping_postcode','shipping_phone','payment_method','invoice_link','paid','gateway_payment_id','date_purchased','order_status','transaction_status',
        'subscription_start_date','payfast_subscription_token'
    ];

    public function user(){
        return $this->belongsTo('App\User');
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
