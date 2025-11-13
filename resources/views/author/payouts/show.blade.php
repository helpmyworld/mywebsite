@extends('layouts.authorLayout.author_design')

@section('content')
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-6 align-self-center">
      <h4 class="text-themecolor">Payout — {{ $payout->period_label }}</h4>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <p><strong>Period:</strong> {{ $payout->from_date }} to {{ $payout->to_date }}</p>
      <p><strong>Amount (ZAR):</strong> {{ number_format($payout->amount, 2) }}</p>
      <p><strong>Status:</strong> {{ ucfirst($payout->status) }}</p>
      <p><strong>Reference:</strong> {{ $payout->reference ?? '-' }}</p>
      @if($payout->proof_path)
        <p><a class="btn btn-sm btn-outline-secondary" target="_blank" href="{{ Storage::disk('public')->url($payout->proof_path) }}">View Proof</a></p>
      @endif
      <p><strong>Notes:</strong><br>{{ $payout->notes }}</p>
      <a href="{{ route('author.payouts.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>
</div>
@endsection
