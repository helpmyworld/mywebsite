<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Author Sales</title>
  <style>
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 6px 8px; border: 1px solid #ccc; }
    th { background: #f5f5f5; }
    h2, h4 { margin: 4px 0; }
  </style>
</head>
<body>
  <h2>Sales Report</h2>
  <h4>Period: {{ $start->toDateString() }} to {{ $end->toDateString() }}</h4>
  <h4>Total Units: {{ number_format($totUnits) }} &nbsp; | &nbsp; Total Revenue (ZAR): {{ number_format($totRevenue, 2) }}</h4>

  <table>
    <thead>
      <tr>
        <th>Order #</th>
        <th>Date</th>
        <th>Book</th>
        <th>Units</th>
        <th>Unit Price</th>
        <th>Revenue</th>
        <th>Payment</th>
        <th>Platform</th>
        <th>Source</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        @php $units = (int)$r->qty; $rev = $units * (float)$r->unit_price; @endphp
        <tr>
          <td>{{ $r->order_id }}</td>
          <td>{{ \Carbon\Carbon::parse($r->order_date)->toDateString() }}</td>
          <td>{{ $r->title }}</td>
          <td>{{ $units }}</td>
          <td>{{ number_format((float)$r->unit_price, 2) }}</td>
          <td>{{ number_format($rev, 2) }}</td>
          <td>{{ $r->payment_method }}</td>
          <td>{{ $r->platform }}</td>
          <td>{{ $r->source }}</td>
        </tr>
      @empty
        <tr><td colspan="9">No data.</td></tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
