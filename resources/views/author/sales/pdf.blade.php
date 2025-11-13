<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sales — {{ $data['period'] }}</title>
  <style>
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #111; }
    h1, h2, h3, h4 { margin: 0 0 6px 0; }
    .muted { color: #666; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ddd; padding: 6px; }
    th { text-align: left; background: #f6f6f6; }
    tfoot th, tfoot td { font-weight: bold; }
    .tr { text-align: right; }
  </style>
</head>
<body>
  <h2>{{ $author->name ?? 'Author' }} — Sales & Royalties</h2>
  <div class="muted">
    Period: {{ $data['period'] }} |
    From: {{ $data['start']->toDateString() }} |
    To: {{ $data['end']->toDateString() }} |
    Timezone: {{ config('reporting.timezone') }} |
    Currency: {{ $data['currency'] }}
  </div>

  <table>
    <thead>
      <tr>
        <th>Book</th>
        <th>Units</th>
        <th class="tr">Revenue (ZAR)</th>
        <th class="tr">Rate %</th>
        <th class="tr">Royalty (ZAR)</th>
      </tr>
    </thead>
    <tbody>
      @forelse($data['by_book'] as $row)
      <tr>
        <td>{{ $row['title'] }}</td>
        <td>{{ number_format($row['units']) }}</td>
        <td class="tr">{{ number_format($row['revenue'], 2) }}</td>
        <td class="tr">{{ number_format($row['rate'], 2) }}</td>
        <td class="tr">{{ number_format($row['royalty'], 2) }}</td>
      </tr>
      @empty
      <tr><td colspan="5">No sales in this period.</td></tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr>
        <th>Total</th>
        <th>{{ number_format($data['totals']['units']) }}</th>
        <th class="tr">{{ number_format($data['totals']['revenue'], 2) }}</th>
        <th></th>
        <th class="tr">{{ number_format($data['totals']['royalty'], 2) }}</th>
      </tr>
    </tfoot>
  </table>
</body>
</html>
