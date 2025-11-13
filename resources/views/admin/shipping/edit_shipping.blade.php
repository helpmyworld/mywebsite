@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Shipping Charges</a> <a href="#" class="current">Add Shipping</a> </div>
    <h1>Categories</h1>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Shipping Charges</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('admin/edit-shipping/'.$shippingDetails->id) }}"
                  name="edit_Shipping" id="edit_Shipping" novalidate="novalidate">{{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $shippingDetails->id}}">
                <div class="control-group">
                <label class="control-label">City or Province</label>
                <div class="controls">
                  <input readonly="" type="text"  value="{{ $shippingDetails->country }}">
                </div>
              </div>

                <div class="control-group">
                    <label class="control-label">Shipping Charges</label>
                    <div class="controls">
                        <input type="text" name="shipping_charges" id="shipping_charges" value="{{ $shippingDetails->shipping_charges }}">
                    </div>
                </div>

              {{--<div class="control-group">--}}
                {{--<label class="control-label">Enable</label>--}}
                {{--<div class="controls">--}}
                  {{--<input type="checkbox" name="status" id="status" @if($shippingDetails->status == "1") checked @endif value="1">--}}
                {{--</div>--}}
              {{--</div>--}}
              <div class="form-actions">
                <input type="submit" value="Edit Shipping" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection