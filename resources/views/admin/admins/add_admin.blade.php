@extends('layouts.adminLayout.admin_design')
@section('content')

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Admins</a> <a href="#" class="current">Add Category</a> </div>
      <h1>Admins</h1>
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
              <h5>Add Admin</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ url('admin/add-admin') }}" name="add_admin" id="add_admin" novalidate="novalidate">{{ csrf_field() }}

                <div class="control-group">
                  <label class="control-label">Type</label>
                  <div class="controls">
                    <select name="type" id="type">
                      <option value="Admin">Admin</option>
                      <option value="Sub Admin">Sub Admin</option>
                    </select>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Username </label>
                  <div class="controls">
                    <input type="text" name="username" id="username" required="">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Password</label>
                  <div class="controls">
                    <input type="text" name="password" id="password" required="">
                  </div>
                </div>
                <div class="control-group" id="access">
                  <label class="control-label">Access</label>
                  <div class="controls">
                    <input type="checkbox" name="categories_access" id="categories_access" value="1" style="margin-top: -3px;">&nbsp;Categories&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="products_access" id="products_access" value="1" style="margin-top: -3px;">&nbsp;Products&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="orders_access" id="orders_access" value="1" style="margin-top: -3px;">&nbsp;Orders&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="users_access" id="users_access" value="1" style="margin-top: -3px;">&nbsp;Users&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="tags_access" id="tags_access" value="1" style="margin-top: -3px;">&nbsp;Tags&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="cats_access" id="cats_access" value="1" style="margin-top: -3px;">&nbsp;Post Category&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="posts_access" id="posts_access" value="1" style="margin-top: -3px;">&nbsp;Posts&nbsp;&nbsp;&nbsp;
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Enable</label>
                  <div class="controls">
                    <input type="checkbox" name="status" id="status" value="1">
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Add Admin" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection