<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    // If your table name is not the plural of the model, keep this:
    protected $table = 'delivery_addresses';

    /**
     * Allow mass-assignment for the fields we write in checkout().
     */
    protected $fillable = [
        'user_id',
        'user_email',
        'name',
        'address',
        'city',
        'state',
        'pincode',
        'country',
        'mobile',
    ];

    // If you prefer to allow everything:
    // protected $guarded = [];

    public $timestamps = true;

    // (Optional) simple relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
