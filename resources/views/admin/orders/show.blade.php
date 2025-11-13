@extends('layouts.adminLayout.admin_design')

@section('content')
<div class="container-fluid">
  {{-- Breadcrumb --}}
  <div class="row page-titles">
    <div class="col-md-6 align-self-center">
      <h4 class="text-themecolor">Order #{{ $order->id }}</h4>
      <small class="text-muted">Placed: {{ \Illuminate\Support\Carbon::parse($order->created_at)->toDayDateTimeString() }}</small>
    </div>
    <div class="col-md-6 align-self-center text-right">
      <a href="{{ url()->previous() }}" class="btn btn-light">Back</a>
    </div>
  </div>

  {{-- Flash / Errors --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="m-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Order Summary --}}
  <div class="row">
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title m-b-10">Order Summary</h5>
          <dl class="m-b-0">
            <dt>Status</dt>
            <dd><span class="badge badge-info">{{ $order->order_status ?? $order->status ?? '—' }}</span></dd>

            <dt class="m-t-10">Payment Method</dt>
            <dd>{{ $order->payment_method ?? '—' }}</dd>

            <dt class="m-t-10">Currency</dt>
            <dd>{{ $order->currency ?? 'ZAR' }}</dd>

            <dt class="m-t-10">Totals</dt>
            <dd>
              @php
                $subTotal = $order->sub_total ?? $order->subtotal ?? $order->grand_total ?? 0;
                $shipping = $order->shipping_charges ?? $order->shipping ?? 0;
                $coupon   = $order->coupon_amount ?? $order->discount ?? 0;
                $grand    = $order->grand_total ?? ($subTotal + $shipping - $coupon);
              @endphp
              <div>Subtotal: {{ number_format((float)$subTotal, 2) }}</div>
              <div>Shipping: {{ number_format((float)$shipping, 2) }}</div>
              <div>Discount: {{ number_format((float)$coupon, 2) }}</div>
              <strong>Grand Total: {{ number_format((float)$grand, 2) }}</strong>
            </dd>
          </dl>
        </div>
      </div>
    </div>

    {{-- Customer --}}
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title m-b-10">Customer</h5>
          <dl class="m-b-0">
            <dt>Name</dt>
            <dd>{{ $order->name ?? ($order->user->name ?? '—') }}</dd>

            <dt class="m-t-10">Email</dt>
            <dd>{{ $order->user->email ?? $order->email ?? '—' }}</dd>

            <dt class="m-t-10">Phone</dt>
            <dd>{{ $order->phone ?? '—' }}</dd>

            <dt class="m-t-10">Address</dt>
            <dd class="m-b-0">
              @php
                $addr = [
                  $order->address ?? null,
                  $order->city ?? null,
                  $order->state ?? null,
                  $order->country ?? null,
                  $order->pincode ?? null,
                ];
                $addr = array_filter($addr, fn($v) => !is_null($v) && $v!=='');
              @endphp
              {{ empty($addr) ? '—' : implode(', ', $addr) }}
            </dd>
          </dl>
        </div>
      </div>
    </div>

    {{-- Full Refund (optional) --}}
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title m-b-10">Issue Full Refund</h5>
          <form method="POST" action="{{ route('admin.orders.refund', ['order' => $order->id]) }}">
            @csrf
            <div class="form-group">
              <label>Amount (ZAR)</label>
              <input type="number" step="0.01" min="0" class="form-control"
                     name="amount" value="{{ number_format((float)$grand, 2, '.', '') }}">
            </div>
            <div class="form-group">
              <label>Reason (optional)</label>
              <input type="text" class="form-control" name="reason" placeholder="Reason for refund">
            </div>
            <button type="submit" class="btn btn-danger btn-block">
              <i class="mdi mdi-cash-refund"></i> Refund Full Order
            </button>
          </form>
          <p class="text-muted m-b-0 m-t-2" style="font-size:12px;">
            This records a refund in the <code>refunds</code> table. Your Sales/Royalties reports will auto-deduct it.
          </p>
        </div>
      </div>
    </div>
  </div>

  {{-- Line Items + Per-line Refund --}}
  @php
    // Try to resolve line items across possible variable names/relations
    $lines = $order->items
             ?? $order->orderProducts
             ?? $order->order_products
             ?? (isset($products) ? $products : null)
             ?? collect();
  @endphp

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Items</h5>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Book</th>
              <th class="text-right">Price</th>
              <th class="text-right">Qty</th>
              <th class="text-right">Line Total</th>
              <th class="text-right" style="width:280px;">Refund</th>
            </tr>
          </thead>
          <tbody>
            @forelse($lines as $i => $line)
              @php
                // Common column names in your schema
                $lineId   = $line->id ?? $line->op_id ?? null;
                $name     = $line->product_name ?? $line->name ?? '—';
                $price    = (float)($line->product_price ?? $line->price ?? 0);
                $qty      = (int)($line->product_qty ?? $line->qty ?? 1);
                $lineTotal= $price * $qty;
              @endphp
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $name }}</td>
                <td class="text-right">{{ number_format($price, 2) }}</td>
                <td class="text-right">{{ number_format($qty) }}</td>
                <td class="text-right">{{ number_format($lineTotal, 2) }}</td>
                <td class="text-right">
                  <form action="{{ route('admin.orders.refund', ['order' => $order->id, 'orderProduct' => $lineId]) }}"
                        method="POST" class="form-inline d-inline">
                    @csrf
                    <div class="input-group" style="max-width:270px; margin-left:auto;">
                      <input type="number" name="amount" step="0.01" min="0"
                             class="form-control" style="width:110px"
                             value="{{ number_format($lineTotal, 2, '.', '') }}">
                      <input type="number" name="units" min="0" class="form-control" style="width:80px"
                             value="{{ $qty }}">
                      <input type="text" name="reason" class="form-control" style="width:200px"
                             placeholder="Reason (optional)">
                      <div class="input-group-append">
                        <button class="btn btn-danger" type="submit" title="Refund line">
                          <i class="mdi mdi-cash-refund"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6">No items found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Refund History --}}
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Refund History</h5>

      @php
        // Prefer controller-provided $refunds; else fallback if order has relation
        $refundsList = $refunds
                       ?? ($order->refunds ?? null)
                       ?? collect();
      @endphp

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Date</th>
              <th>Order Product #</th>
              <th class="text-right">Amount (ZAR)</th>
              <th class="text-right">Units</th>
              <th>Reason</th>
            </tr>
          </thead>
          <tbody>
            @forelse($refundsList as $r)
              <tr>
                <td>{{ \Illuminate\Support\Carbon::parse($r->refunded_at ?? $r->created_at)->toDayDateTimeString() }}</td>
                <td>{{ $r->order_product_id ?? '—' }}</td>
                <td class="text-right">{{ number_format((float)$r->amount, 2) }}</td>
                <td class="text-right">{{ number_format((int)($r->units ?? 0)) }}</td>
                <td>{{ $r->reason ?? '—' }}</td>
              </tr>
            @empty
              <tr><td colspan="5">No refunds recorded for this order.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <p class="text-muted m-b-0" style="font-size:12px;">
        Refunds here write to the <code>refunds</code> table. The author Sales & Royalties reports automatically subtract refunded
        amounts/units for the selected period.
      </p>
    </div>
  </div>

</div>
@endsection
