@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <a href="#" class="current">View Banners</a>
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
            <span class="icon"><i class="icon-th"></i></span>
            <h5>All Banners</h5>
            <div class="buttons">
              <a href="{{ url('admin/add-banner') }}" class="btn btn-success btn-mini">Add New</a>
            </div>
          </div>

          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Link</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($banners as $banner)
                <tr>
                  <td>{{ $banner->id }}</td>
                  <td style="width:120px;">
                    @if(!empty($banner->image))
                      <img src="{{ asset('images/frontend_images/banners/small/'.$banner->image) }}"
                           alt="Banner" style="max-height:70px;">
                    @endif
                  </td>
                  <td>{{ $banner->title }}</td>
                  <td>{{ \Illuminate\Support\Str::limit($banner->description, 80, '…') }}</td>
                  <td>
                    @if(!empty($banner->link))
                      <a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a>
                    @endif
                  </td>
                  <td>
                    @if(!empty($banner->status) && $banner->status == 1)
                      <span class="label label-success">Enabled</span>
                    @else
                      <span class="label">Disabled</span>
                    @endif
                  </td>
                  <td style="min-width:140px;">
                    <a href="{{ url('admin/edit-banner/'.$banner->id) }}" class="btn btn-primary btn-mini">Edit</a>
                    <a href="{{ url('admin/delete-banner/'.$banner->id) }}"
                       class="btn btn-danger btn-mini"
                       onclick="return confirm('Delete this banner?');">Delete</a>
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
@endsection
