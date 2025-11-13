@extends('layouts.adminLayout.admin_design')
@section('content')
  
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">posters</a> <a href="#" class="current">View posters</a> </div>
    <h1>posters</h1>
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
            <h5>posters</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>poster ID</th>
                  <th>Title</th>
                  <th>Link</th>
                  <th>Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($posters as $poster)
                <tr class="gradeX">
                  <td class="center">{{ $poster->id }}</td>
                  <td class="center">{{ $poster->title }}</td>
                  <td class="center">{{ $poster->link }}</td>
                  <td class="center">
                    @if(!empty($poster->image))
                    <img src="{{ asset('/images/frontend_images/posters/'.$poster->image) }}" style="width:250px;">
                    @endif
                  </td>
                  <td class="center">
                    <a href="{{ url('/admin/edit-poster/'.$poster->id) }}" class="btn btn-primary btn-mini">Edit</a> 
                    <a id="delposter" rel="{{ $poster->id }}" rel1="delete-poster" href="javascript:" <?php /* href="{{ url('/admin/delete-poster/'.$poster->id) }}" */ ?> class="btn btn-danger btn-mini deleteRecord">Delete</a>
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
