<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PayoutController extends Controller
{
    public function index()
    {
        $payouts = Payout::orderByDesc('id')->paginate(20);
        return view('admin.payouts.index', compact('payouts'));
    }

    public function update(Request $request, $id)
    {
        $payout = Payout::findOrFail($id);
        $payout->status = $request->get('status', $payout->status);
        $payout->reference = $request->get('reference', $payout->reference);
        $payout->notes = $request->get('notes', $payout->notes);

        if ($request->hasFile('proof')) {
            $payout->proof_path = $request->file('proof')->store('payout_proofs', 'public');
        }

        $payout->save();
        return back()->with('success','Payout updated.');
    }
}
