<?php

namespace App\Services;

use App\Models\EbookLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EbookLinkService
{
    public function createLink(int $orderId, int $orderProductId, int $productId, ?int $buyerId, string $filePath): EbookLink
    {
        $token = EbookLink::makeToken();
        $expires = now(config('reporting.timezone'))->addHours(config('ebooks.expiry_hours', 72));

        return EbookLink::create([
            'token'            => $token,
            'order_id'         => $orderId,
            'order_product_id' => $orderProductId,
            'product_id'       => $productId,
            'buyer_id'         => $buyerId,
            'file_path'        => $filePath,
            'max_attempts'     => config('ebooks.max_attempts', 5),
            'attempts'         => 0,
            'expires_at'       => $expires,
        ]);
    }

    public function sendEmail(string $toEmail, string $toName, EbookLink $link): void
    {
        $url = route('product.download_ebook', ['token' => $link->token]);
        Mail::send('emails.ebook_link', compact('toName','url','link'), function($m) use ($toEmail, $toName) {
            $m->to($toEmail, $toName)->subject('Your e-book download link');
        });
    }
}
