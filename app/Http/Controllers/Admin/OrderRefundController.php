<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderRefundController extends Controller
{
    public function store(Request $request, $orderId, $orderProductId = null)
    {
        $order = Order::findOrFail($orderId);

        // Validate input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'units'  => 'nullable|integer|min:0',
            'reason' => 'nullable|string|max:500',
        ]);

        // Create refund record
        Refund::create([
            'order_id'         => $order->id,
            'order_product_id' => $orderProductId,
            'amount'           => $validated['amount'],
            'units'            => $validated['units'] ?? 0,
            'reason'           => $validated['reason'] ?? null,
            'refunded_at'      => now(config('reporting.timezone')),
        ]);

        // Optional: update order status if full refund
        if ($orderProductId === null && (float)$validated['amount'] >= $order->grand_total) {
            $order->order_status = 'Refunded';
            $order->save();
        }

        return back()->with('success', 'Refund recorded successfully.');
    }
}
