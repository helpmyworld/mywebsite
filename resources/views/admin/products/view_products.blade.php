@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">View Products</a> </div>
    <h1>Products</h1>
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
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Products</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Category ID</th>
                  <th>Category Name</th>
                  <th>Product Name</th>
                 
                  <th>Price</th>
                  <th>Image</th>
                  <th>Featured Item</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
                <tr class="gradeX">
                  <td class="center" data-order="{{ (int)$product->id }}">{{ $product->id }}</td>
                  <td class="center">{{ $product->category_id }}</td>
                  <td class="center">{{ $product->category_name }}</td>
                  <td class="center">{{ $product->product_name }}</td>
                  
                  <td class="center">{{ $product->price }}</td>
                  <td class="center">
                    @if(!empty($product->image))
                    <img src="{{ asset('/images/backend_images/product/small/'.$product->image) }}" style="width:50px;">
                    @endif
                  </td>
                  <td class="center">@if( $product->feature_item == 1 ) Yes @else No @endif</td>
                  <td class="center">@if( $product->approved) Approved @else Waiting Approval @endif</td>

                  <td class="center">
                    <a href="#myModal{{ $product->id }}" data-toggle="modal" class="btn btn-success btn-mini">View</a> 
                    <a href="{{ url('/admin/edit-product/'.$product->id) }}" class="btn btn-primary btn-mini">Edit</a> 
                    <a href="{{ url('/admin/add-attributes/'.$product->id) }}" class="btn btn-success btn-mini">Add</a>
                    <a href="{{ url('/admin/add-images/'.$product->id) }}" class="btn btn-info btn-mini">Add</a>
                    <a id="delProduct" rel="{{ $product->id }}" rel1="delete-product" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                    @if( $product->approved)
                      <a href="{{ url('/admin/product/disapprove/'.$product->id) }}" class="btn btn-info btn-mini">Disapprove</a>
                    @else
                      <a href="{{ url('/admin/product/approve/'.$product->id) }}" class="btn btn-info btn-mini">Approve</a>
                    @endif
 
                        <div id="myModal{{ $product->id }}" class="modal hide">
                          <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">×</button>
                            <h3>{{ $product->product_name }} Full Details</h3>
                          </div>
                          <div class="modal-body">
                            <p>Product ID: {{ $product->id }}</p>
                            <p>Category ID: {{ $product->category_id }}</p>
                          
                            <p>Price: {{ $product->price }}</p>
                         
                            <p>Description: {{ $product->description }}</p>
                          </div>
                        </div>

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Force latest sorting (ID desc) no matter how the theme init works --}}
<script>
  (function() {
    function intIdFromRow(tr){
      var txt = jQuery(tr).find('td:first').attr('data-order') || jQuery(tr).find('td:first').text();
      return parseInt(txt, 10) || 0;
    }

    function manualSortDesc($table){
      var rows = $table.find('tbody > tr').get();
      rows.sort(function(a,b){
        return intIdFromRow(b) - intIdFromRow(a);
      });
      jQuery.each(rows, function(_, r){ $table.children('tbody').append(r); });
    }

    jQuery(function($){
      var $t = $('.data-table');

      if (!$t.length) return;

      // Fallback: ensure DOM rows are already latest-first (helps even without DataTables)
      manualSortDesc($t);

      // If DataTables is available
      if ($.fn.dataTable) {
        try {
          if ($.fn.dataTable.isDataTable($t)) {
            // Already initialized by theme: force order via API
            var api = $t.DataTable();
            api.order([0,'desc']).draw(false);
          } else {
            // Initialize ourselves with the correct default order
            $t.DataTable({
              order: [[0, 'desc']],
              columnDefs: [
                { targets: 0, type: 'num' } // ensure numeric sort on ID column
              ],
              retrieve: true
            });
          }
        } catch(e) {
          // As a last resort, at least keep the manual DOM order we set above
          console.warn('DataTables ordering fallback used:', e);
        }
      }
    });
  })();
</script>

@endsection
