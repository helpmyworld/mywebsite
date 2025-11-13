@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <a href="#">Authors</a>
      <a href="#" class="current">View Authors</a>
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
            <span class="icon"><i class="icon-th"></i></span>
            <h5>View Authors</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Bio</th>
                  <th>Featured</th>
                  <th>Image</th>
                  <th>Created At</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($authors as $author)
                  <tr class="gradeX">
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->email ?? '-' }}</td>
                    <td>{{ $author->bio }}</td>
                    <td>
                      @if($author->is_featured)
                        <span class="label label-success">Yes</span>
                      @else
                        <span class="label label-important">No</span>
                      @endif
                    </td>

                    <td>
                      @if(!empty($author->image))
                        <img src="{{ asset('images/backend_images/authors/'.$author->image) }}" alt="" width="60">
                      @else
                        <img src="{{ asset('images/backend_images/no-image.png') }}" alt="" width="60">
                      @endif
                    </td>

                    <td>{{ $author->created_at ? $author->created_at->format('Y-m-d') : '-' }}</td>
                    <td class="center">
                      <a href="{{ url('/admin/edit-author/'.$author->id) }}" class="btn btn-primary btn-mini">Edit</a>
                      <a href="{{ url('/admin/delete-author/'.$author->id) }}" class="btn btn-danger btn-mini" id="delAuthor">Delete</a>
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
