@extends('layouts.authorLayout.author_design')

@section('content')
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-6 align-self-center">
      <h4 class="text-themecolor">Sales & Royalties — {{ $data['period'] }}</h4>
      <small>Period: {{ $data['start']->toDateString() }} to {{ $data['end']->toDateString() }} ({{ config('reporting.timezone') }})</small>
    </div>
    <div class="col-md-6 align-self-center">
      <form method="get" class="d-flex justify-content-end align-items-center" style="gap:10px;">
        <select name="period" id="period" class="form-control" style="max-width:190px" onchange="toggleCustom(true)">
          <option value="this"  @if($period==='this') selected @endif>This Quarter</option>
          <option value="last"  @if($period==='last') selected @endif>Last Quarter</option>
          <option value="ytd"   @if($period==='ytd') selected @endif>YTD</option>
          <optgroup label="Specific quarter">
            @php
              $y = now(config('reporting.timezone'))->year;
              $qs = ["{$y}-Q1","{$y}-Q2","{$y}-Q3","{$y}-Q4", ($y-1)."-Q1", ($y-1)."-Q2", ($y-1)."-Q3", ($y-1)."-Q4"];
            @endphp
            @foreach($qs as $q)
              <option value="{{ $q }}" @if($period===$q) selected @endif>{{ $q }}</option>
            @endforeach
          </optgroup>
          <option value="custom" @if($period==='custom') selected @endif>Custom Range</option>
        </select>

        <input type="date" name="from" id="from" class="form-control" style="max-width:155px" value="{{ request('from') }}">
        <input type="date" name="to"   id="to"   class="form-control" style="max-width:155px" value="{{ request('to') }}">

        <select name="product_id" class="form-control" style="max-width:220px">
          <option value="">All Books</option>
          @foreach($data['filters']['available_products'] as $p)
            <option value="{{ $p->id }}" @if((int)request('product_id') === (int)$p->id) selected @endif>{{ $p->product_name }}</option>
          @endforeach
        </select>

        <button class="btn btn-primary" type="submit">Apply</button>

        <a class="btn btn-outline-secondary" href="{{ route('author.sales.csv', request()->query()) }}">Export CSV</a>
        <a class="btn btn-outline-secondary" href="{{ route('author.sales.pdf', request()->query()) }}">Export PDF</a>
      </form>
      <script>
        function toggleCustom(isUserChange){
          var p = document.getElementById('period').value;
          var from = document.getElementById('from');
          var to   = document.getElementById('to');
          var show = (p === 'custom');
          from.style.display = show ? 'block' : 'none';
          to.style.display   = show ? 'block' : 'none';
          if(!show){ from.value=''; to.value=''; }
          if(isUserChange && p !== 'custom'){ from.form.submit(); }
        }
        document.addEventListener('DOMContentLoaded', function(){ toggleCustom(false); });
      </script>
    </div>
  </div>

  <div class="row m-t-20">
    <div class="col-lg-3 col-md-6">
      <div class="card card-body">
        <h6 class="m-b-0">Total Units</h6>
        <h3 class="m-b-0">{{ number_format($data['totals']['units']) }}</h3>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="card card-body">
        <h6 class="m-b-0">Total Revenue (ZAR)</h6>
        <h3 class="m-b-0">{{ number_format($data['totals']['revenue'], 2) }}</h3>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="card card-body">
        <h6 class="m-b-0">Total Royalty (ZAR)</h6>
        <h3 class="m-b-0">{{ number_format($data['totals']['royalty'], 2) }}</h3>
      </div>
    </div>
  </div>

  <div class="row m-t-10">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">By Book</h5>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Book</th>
                  <th>Units</th>
                  <th class="text-right">Revenue (ZAR)</th>
                  <th class="text-right">Rate %</th>
                  <th class="text-right">Royalty (ZAR)</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data['by_book'] as $row)
                  <tr>
                    <td>{{ $row['title'] }}</td>
                    <td>{{ number_format($row['units']) }}</td>
                    <td class="text-right">{{ number_format($row['revenue'], 2) }}</td>
                    <td class="text-right">{{ number_format($row['rate'], 2) }}</td>
                    <td class="text-right">{{ number_format($row['royalty'], 2) }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5">No sales in this period.</td></tr>
                @endforelse
              </tbody>
              @if(!empty($data['by_book']))
              <tfoot>
                <tr>
                  <th>Total</th>
                  <th>{{ number_format($data['totals']['units']) }}</th>
                  <th class="text-right">{{ number_format($data['totals']['revenue'], 2) }}</th>
                  <th></th>
                  <th class="text-right">{{ number_format($data['totals']['royalty'], 2) }}</th>
                </tr>
              </tfoot>
              @endif
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Details table --}}
  <div class="row m-t-10">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Sales Details</h5>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Date</th>
                  <th>Book</th>
                  <th>Units</th>
                  <th>Unit Price</th>
                  <th>Buyer</th>
                  <th>Email</th>
                  <th>Payment</th>
                  <th>Platform</th>
                  <th>Source</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data['details'] as $r)
                  <tr>
                    <td>{{ $r->order_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->order_date)->toDateString() }}</td>
                    <td>{{ $r->title }}</td>
                    <td>{{ $r->qty }}</td>
                    <td>{{ number_format((float)$r->unit_price, 2) }}</td>
                    <td>{{ $r->buyer_name }}</td>
                    <td>{{ $r->buyer_email }}</td>
                    <td>{{ $r->payment_method }}</td>
                    <td>{{ $r->platform }}</td>
                    <td>{{ $r->source }}</td>
                  </tr>
                @empty
                  <tr><td colspan="10">No sales in this period.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- NEW: By Month summary --}}
  <div class="row m-t-10">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">By Month</h5>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Month</th>
                  <th class="text-right">Units</th>
                  <th class="text-right">Revenue (ZAR)</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data['by_month'] as $m)
                  <tr>
                    <td>{{ $m['month'] }}</td>
                    <td class="text-right">{{ number_format($m['units']) }}</td>
                    <td class="text-right">{{ number_format($m['revenue'], 2) }}</td>
                  </tr>
                @empty
                  <tr><td colspan="3">No data.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- NEW: By Platform & Payment Method --}}
  <div class="row m-t-10 m-b-40">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">By Platform & Payment Method</h5>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Platform</th>
                  <th>Payment Method</th>
                  <th class="text-right">Units</th>
                  <th class="text-right">Revenue (ZAR)</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data['by_platform_method'] as $pm)
                  <tr>
                    <td>{{ $pm['platform'] ?: '-' }}</td>
                    <td>{{ $pm['payment_method'] ?: '-' }}</td>
                    <td class="text-right">{{ number_format($pm['units']) }}</td>
                    <td class="text-right">{{ number_format($pm['revenue'], 2) }}</td>
                  </tr>
                @empty
                  <tr><td colspan="4">No data.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
