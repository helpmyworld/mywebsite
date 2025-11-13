@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Admin</a> <a href="#" class="current">Add Category</a> </div>
    <h1>Admin</h1>
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
            <h5>Edit Admin</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('admin/edit-admin/'.$adminDetails->id) }}" name="add_admin" id="add_admin" novalidate="novalidate">{{ csrf_field() }}
              {{--<div class="control-group">--}}
                {{--<select name="type" id="type" style="width: 220px;">--}}
                  {{--<option value="Admin">Admin </option>--}}
                  {{--<option value="Sub Admin">Sub Admin </option>--}}
                {{--</select>--}}
                {{--<input type="text" name="type" id="type" readonly="" value="{{$adminDetails->type}}">--}}
              {{--</div>--}}
              <div class="control-group">
                <label class="control-label">Type</label>
                <div class="controls">
                  <input type="text" name="type" id="type" readonly="" value="{{$adminDetails->type}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                  <input type="text" name="username" id="username" readonly="" value="{{$adminDetails->username}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                  <input type="password" name="password" id="password" required="" >
                </div>
              </div>
              @if($adminDetails->type=="Sub Admin")
              <div class="control-group" >
                <label class="control-label">Access</label>
                <div class="controls">
                  <input type="checkbox" name="categories_access" id="categories_access" value="1" style="margin-top: -3px;"
                  @if($adminDetails->categories_access == "1") checked @endif>&nbsp;Categories&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="products_access" id="products_access" value="1" style="margin-top: -3px;"
                         @if($adminDetails->products_access == "1") checked @endif>&nbsp;Products&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="orders_access" id="orders_access" value="1" style="margin-top: -3px;"
                         @if($adminDetails->orders_access == "1") checked @endif>&nbsp;Orders&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="users_access" id="users_access" value="1" style="margin-top: -3px;"
                         @if($adminDetails->users_access == "1") checked @endif>&nbsp;Users&nbsp;&nbsp;&nbsp;

                  <input type="checkbox" name="tags_access" id="tags_access" value="1" style="margin-top: -3px;"
                         @if($adminDetails->tags_access == "1") checked @endif>&nbsp;Tags&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="cats_access" id="cats_access" value="1" style="margin-top: -3px;"
                         @if($adminDetails->cats_access == "1") checked @endif>&nbsp;Post Category&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="posts_access" id="posts_access" value="1" style="margin-top: -3px;"
                         @if($adminDetails->posts_access == "1") checked @endif>&nbsp;Post&nbsp;&nbsp;&nbsp;
                </div>
              </div>
              @endif
              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1"
                         @if($adminDetails->status == "1") checked @endif>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Edit Admin" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection