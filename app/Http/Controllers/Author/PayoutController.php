<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    public function index(Request $request)
    {
        $authorId = Auth::id();
        $payouts = Payout::where('author_id', $authorId)->orderByDesc('id')->paginate(15);
        return view('author.payouts.index', compact('payouts'));
    }

    public function show($id)
    {
        $authorId = Auth::id();
        $payout = Payout::where('author_id', $authorId)->findOrFail($id);
        return view('author.payouts.show', compact('payout'));
    }
}
