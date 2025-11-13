@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <a href="#">Authors</a>
      <a href="#" class="current">Add Author</a>
    </div>
    <h1>Authors</h1>

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
          <div class="widget-title">
            <span class="icon"><i class="icon-info-sign"></i></span>
            <h5>Add Author</h5>
          </div>

          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post"
                  action="{{ url('admin/add-author') }}" name="add_author" id="add_author" novalidate="novalidate">
              {{ csrf_field() }}

              <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                  <input type="email" name="email" id="email" value="{{ old('email') }}">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Bio</label>
                <div class="controls">
                  <textarea name="bio" id="bio" rows="5">{{ old('bio') }}</textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Featured</label>
                <div class="controls">
                  <input type="checkbox" name="is_featured" id="is_featured" value="1">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Author Image</label>
                <div class="controls">
                  <input type="file" name="image" id="image">
                  <span class="help-block">Upload author image (JPEG, PNG, GIF)</span>
                </div>
              </div>

              <div class="form-actions">
                <input type="submit" value="Add Author" class="btn btn-success">
                <a href="{{ url('admin/view-authors') }}" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
