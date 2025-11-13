@extends('layouts.authorLayout.author_design')
@section('content')
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Ask a question</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Ask a question</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- End Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Container fluid  -->
  <!-- ============================================================== -->
  <div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          @include('layouts.response')
          <form class="form-horizontal" action="{{route('author.questions.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{auth()->id()}}">
            <input type="hidden" name="type" value="Question">
            <div class="card-body">
              <h4 class="card-title">Post a question</h4>
              <div class="form-group row">
                <label for="title" class="col-sm-3 text-right control-label col-form-label">Title</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" placeholder="Enter Title" required value="{{old('title')}}">
                  @if ($errors->has('title'))
                    <span class="invalid-feedback">
                                              <strong>{{ $errors->first('title') }} </strong>
                                            </span>
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="title" class="col-sm-3 text-right control-label col-form-label">Content</label>
                <div class="col-sm-9">
                  <textarea  class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" id="title" name="body" placeholder="Enter Content" required >{{old('body')}}</textarea>
                  @if ($errors->has('body'))
                    <span class="invalid-feedback">
                                              <strong>{{ $errors->first('body') }} </strong>
                                            </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="border-top">
              <div class="card-body">
                <button type="submit" class="btn btn-primary">Post</button>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

  </div>
  <!-- ============================================================== -->
  <!-- End Container fluid  -->
  <!-- ============================================================== -->

  @endsection