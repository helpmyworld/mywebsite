@extends('layouts.authorLayout.author_design')

@section('content')
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-6 align-self-center">
      <h4 class="text-themecolor">Payouts</h4>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Period</th>
              <th>From</th>
              <th>To</th>
              <th class="text-right">Amount (ZAR)</th>
              <th>Status</th>
              <th>Ref</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse($payouts as $p)
              <tr>
                <td>{{ $p->period_label }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($p->from_date)->toDateString() }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($p->to_date)->toDateString() }}</td>
                <td class="text-right">{{ number_format($p->amount, 2) }}</td>
                <td>{{ ucfirst($p->status) }}</td>
                <td>{{ $p->reference }}</td>
                <td><a href="{{ route('author.payouts.show', $p->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
              </tr>
            @empty
              <tr><td colspan="7">No payouts yet.</td></tr>
            @endforelse
          </tbody>
        </table>
        <div>{{ $payouts->links() }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
