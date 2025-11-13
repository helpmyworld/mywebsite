@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <a href="#">Users</a>
      <a href="#" class="current">Edit User</a>
    </div>
    <h1>Users</h1>

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
            <h5>Edit User</h5>
          </div>

          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post"
                  action="{{ url('/admin/edit-user/'.$user->id) }}" name="edit_users" id="edit_users" novalidate="novalidate">
              {{ csrf_field() }}

              <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                  <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Type</label>
                <div class="controls">
                  <select name="type" id="type" class="span6">
                    <option value="User" {{ old('type',$user->type)=='User' ? 'selected' : '' }}>User</option>
                    <option value="Author" {{ old('type',$user->type)=='Author' ? 'selected' : '' }}>Author</option>
                  </select>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Bio</label>
                <div class="controls">
                  <textarea name="bio" id="bio" rows="5" class="span8">{{ old('bio', $user->bio) }}</textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Featured Author</label>
                <div class="controls">
                  <label style="display:inline-block;">
                    <input type="checkbox" name="featured_author" id="featured_author" value="1" {{ old('featured_author', $user->featured_author) ? 'checked' : '' }}>
                    Featured user
                  </label>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">User Image</label>
                <div class="controls">
                  <input type="file" name="profile_image" id="profile_image">
                  @if(!empty($user->profile_image))
                    <img src="{{ asset('images/users/'.$user->profile_image) }}" alt="{{ $user->name }}" style="width:60px; margin-left:10px;">
                  @endif
                  <span class="help-block">Upload to replace current image.</span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Books (Products)</label>
                <div class="controls">
                  <select name="product_ids[]" id="product_ids" class="span8" multiple>
                    @foreach($products as $product)
                      <option value="{{ $product->id }}"
                        {{ in_array($product->id, $selectedProductIds) ? 'selected' : '' }}>
                        {{ $product->product_name ?? $product->name ?? $product->title ?? ('#'.$product->id) }}
                      </option>
                    @endforeach
                  </select>
                  <span class="help-block">Select any books to associate; you can also leave this empty.</span>
                </div>
              </div>

              <div class="form-actions">
                <input type="submit" value="Update User" class="btn btn-success">
                <a href="{{ url('/admin/view-users') }}" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
