@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <a href="{{ url('admin/view-banners') }}">Banners</a>
      <a href="#" class="current">Edit Banner</a>
    </div>
    <h1>Banners</h1>

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
            <h5>Edit Banner</h5>
          </div>

          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post"
                  action="{{ url('admin/edit-banner/'.$bannerDetails->id) }}" name="edit_banner" id="edit_banner" novalidate="novalidate">
              {{ csrf_field() }}

              {{-- Title --}}
              <div class="control-group">
                <label class="control-label">Banner Title</label>
                <div class="controls">
                  <input type="text" name="title" class="span11"
                         value="{{ old('title', $bannerDetails->title ?? '') }}">
                </div>
              </div>

              {{-- Description --}}
              <div class="control-group">
                <label class="control-label">Banner Description</label>
                <div class="controls">
                  <textarea name="description" rows="3" class="span11">{{ old('description', $bannerDetails->description ?? '') }}</textarea>
                </div>
              </div>

              {{-- Link --}}
              <div class="control-group">
                <label class="control-label">Link</label>
                <div class="controls">
                  <input type="text" name="link" class="span11"
                         value="{{ old('link', $bannerDetails->link ?? '') }}">
                </div>
              </div>

              {{-- Image --}}
              <div class="control-group">
                <label class="control-label">Image</label>
                <div class="controls">
                  <input type="file" name="image" class="span11">
                  @if(!empty($bannerDetails->image))
                    <img src="{{ asset('images/frontend_images/banners/small/'.$bannerDetails->image) }}"
                         alt="Banner" style="max-height:80px; margin-top:8px;">
                    <input type="hidden" name="current_image" value="{{ $bannerDetails->image }}">
                  @endif
                  <span class="help-block">Recommended sizes: Large 1146x441, Medium 600x231, Small 300x115</span>
                </div>
              </div>

              {{-- Status --}}
              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" value="1"
                         @if(!empty($bannerDetails->status) && $bannerDetails->status == "1") checked @endif>
                </div>
              </div>

              <div class="form-actions">
                <input type="submit" value="Update Banner" class="btn btn-success">
                <a href="{{ url('admin/view-banners') }}" class="btn btn-default">Cancel</a>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
