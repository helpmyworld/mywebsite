<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'author_id','period_label','from_date','to_date','amount',
        'status','reference','proof_path','notes'
    ];

    public function authorUser() {
        // In your schema, products.user_id represents the author user account
        return $this->belongsTo(\App\User::class, 'author_id');
    }
}
