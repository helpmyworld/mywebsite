<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Product;

class BuyNowController extends Controller
{
    /**
     * Add a single product to cart (qty=1 by default) and go straight to checkout.
     * Works for both logged-in users and guests (guest will be asked to login, then redirected to checkout).
     */
    public function buy(Request $request, $productId)
    {
        $qty = max(1, (int)$request->get('qty', 1));

        // Ensure product exists & is enabled
        $product = Product::where('id', $productId)->where('status', 1)->firstOrFail();

        // Resolve identifiers
        $sessionId = session()->get('session_id');
        if (!$sessionId) {
            $sessionId = Str::random(40);
            session()->put('session_id', $sessionId);
        }

        $userEmail = Auth::check() ? Auth::user()->email : '';

        // Remove other items if you want a truly single-item “buy now”
        // Comment the next line if you prefer to keep existing cart content.
        DB::table('cart')->where(function($q) use ($userEmail, $sessionId) {
            if ($userEmail) { $q->where('user_email', $userEmail); }
            else { $q->where('session_id', $sessionId); }
        })->delete();

        // Insert line (reuse your existing cart schema)
        DB::table('cart')->insert([
            'product_id'   => $product->id,
            'product_name' => $product->product_name,
            'product_type' => $product->type,         // ebook / Physical Book
            'product_code' => $product->product_code, // you don’t use size here
            'product_color'=> $product->product_color ?? '',
            'price'        => $product->price,
            'quantity'     => $qty,
            'user_email'   => $userEmail,
            'session_id'   => $sessionId,
        ]);

        // If not logged in, remember we want to land in checkout after login
        if (!Auth::check()) {
            session()->put('url.intended', url('checkout'));
            return redirect()->route('login');
        }

        return redirect('checkout');
    }
}
