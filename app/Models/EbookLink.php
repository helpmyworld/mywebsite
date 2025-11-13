<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EbookLink extends Model
{
    protected $fillable = [
        'token','order_id','order_product_id','product_id','buyer_id',
        'file_path','max_attempts','attempts','expires_at'
    ];

    protected $dates = ['expires_at'];

    public static function makeToken(): string {
        return Str::random(48);
    }

    public function isExpired(): bool {
        return now(config('reporting.timezone'))->greaterThan($this->expires_at);
    }

    public function canDownload(): bool {
        return !$this->isExpired() && $this->attempts < $this->max_attempts;
    }
}
