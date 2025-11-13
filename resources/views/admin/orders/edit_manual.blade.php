@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="{{ url('admin/dashboard') }}" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Orders</a>
      <a href="#" class="current">Edit Manual Order</a>
    </div>
    <h1>Edit Manual Order #{{ $order->id }}</h1>
    @if(Session::has('flash_message_error'))
      <div class="alert alert-error alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{!! session('flash_message_error') !!}</strong>
      </div>
    @endif
    @if(Session::has('flash_message_success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{!! session('flash_message_success') !!}</strong>
      </div>
    @endif
  </div>

  <div class="container-fluid">
    <hr>

    <form method="post" action="{{ url('admin/edit-manual-order/'.$order->id) }}">
      @csrf

      <div class="row-fluid">
        <div class="span6">
          <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-user"></i></span><h5>Buyer / Customer</h5></div>
            <div class="widget-content">
              <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                  <input type="text" name="customer_name" class="span11" value="{{ old('customer_name', $order->name) }}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                  <input type="email" name="customer_email" class="span11" value="{{ old('customer_email', $order->user_email) }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Date</label>
                <div class="controls">
                  <input type="date" name="order_date" class="span11" value="{{ old('order_date', optional($order->created_at)->toDateString()) }}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Mark as Paid</label>
                <div class="controls">
                  <label><input type="checkbox" name="mark_as_paid" value="1" {{ old('mark_as_paid', $order->order_status === 'Paid') ? 'checked' : '' }}> Paid</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="span6">
          <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-file"></i></span><h5>Invoice / Payment</h5></div>
            <div class="widget-content">
              <div class="control-group">
                <label class="control-label">Order Number</label>
                <div class="controls">
                  <input type="text" name="order_number" class="span11" value="{{ old('order_number', $order->order_number) }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Invoice Number / Reference</label>
                <div class="controls">
                  <input type="text" name="invoice_number" class="span11" value="{{ old('invoice_number', $order->invoice_number) }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Payment Method</label>
                <div class="controls">
                  <select name="payment_method" class="span11" required>
                    @foreach(['EFT','Cash','Card','Other'] as $pm)
                      <option value="{{ $pm }}" @selected(old('payment_method', $order->payment_method)===$pm)>{{ $pm }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Platform</label>
                <div class="controls">
                  <select name="platform" class="span11">
                    @foreach(['Invoice','In-store','Website','Takealot','Other'] as $pf)
                      <option value="{{ $pf }}" @selected(old('platform', $order->platform)===$pf)>{{ $pf }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-list"></i></span><h5>Items</h5></div>
            <div class="widget-content nopadding">
              <table class="table table-bordered" id="items-table">
                <thead>
                <tr>
                  <th style="width:40%;">Product</th>
                  <th style="width:15%;">Qty</th>
                  <th style="width:20%;">Unit Price</th>
                  <th style="width:10%;">Remove</th>
                </tr>
                </thead>
                <tbody>
                @php $idx = 0; @endphp
                @foreach($order->orders as $row)
                  <tr>
                    <td>
                      <select name="items[{{ $idx }}][product_id]" class="span12" required>
                        <option value="">-- Select product --</option>
                        @foreach($products as $p)
                          <option value="{{ $p->id }}" @selected($p->id == $row->product_id)>{{ $p->product_name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="number" name="items[{{ $idx }}][qty]" class="span12" min="1" value="{{ $row->product_qty }}" required></td>
                    <td><input type="number" step="0.01" name="items[{{ $idx }}][unit_price]" class="span12" value="{{ $row->product_price }}"></td>
                    <td><button type="button" class="btn btn-danger btn-mini remove-row">&times;</button></td>
                  </tr>
                  @php $idx++; @endphp
                @endforeach
                </tbody>
              </table>
              <div class="form-actions">
                <button type="button" id="add-row" class="btn btn-secondary">Add Item</button>
                <button type="submit" class="btn btn-success">Update Order</button>
                <a href="{{ url('admin/view-orders') }}" class="btn btn-default">Cancel</a>
                <a href="{{ url('admin/delete-manual-order/'.$order->id) }}" class="btn btn-danger" onclick="return confirm('Delete this order?')">Delete Order</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
(function(){
  let idx = {{ $idx ?? 0 }};
  document.getElementById('add-row').addEventListener('click', function(){
    const tbody = document.querySelector('#items-table tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <select name="items[${idx}][product_id]" class="span12" required>
          <option value="">-- Select product --</option>
          @foreach($products as $p)
            <option value="{{ $p->id }}">{{ $p->product_name }}</option>
          @endforeach
        </select>
      </td>
      <td><input type="number" name="items[${idx}][qty]" class="span12" min="1" value="1" required></td>
      <td><input type="number" step="0.01" name="items[${idx}][unit_price]" class="span12" placeholder="blank = product price"></td>
      <td><button type="button" class="btn btn-danger btn-mini remove-row">&times;</button></td>
    `;
    tbody.appendChild(tr);
    idx++;
  });

  document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-row')){
      e.target.closest('tr').remove();
    }
  });
})();
</script>
@endsection
