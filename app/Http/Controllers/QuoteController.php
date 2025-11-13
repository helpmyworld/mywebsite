<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Quote;
use App\Mail\QuoteSubmitted;

class QuoteController extends Controller
{
    public function create()
    {
        return view('quote.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'email' => ['required','email','max:255'],
            'phone' => ['nullable','string','max:60'],
            'project_type' => ['required','string','max:120'],
            'budget' => ['nullable','string','max:60'],
            'message' => ['required','string','max:5000'],
        ]);

        $quote = Quote::create($data);

        $notify = env('QUOTE_NOTIFY_EMAIL', config('mail.from.address'));
        if ($notify) {
            Mail::to($notify)->send(new QuoteSubmitted($quote));
        }

        return back()->with('success', 'Thanks, your request has been received. We will get back to you shortly.');
    }
}
