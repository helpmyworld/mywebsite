@extends('layouts.authorLayout.author_design')
@section('content')
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Upload Manuscript</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Upload Manuscript</li>
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
          <form class="form-horizontal" action="{{route('author.manuscripts.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{auth()->id()}}">
            <div class="card-body">
              <h4 class="card-title">Upload Manuscript</h4>
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
                <label for="filename" class="col-sm-3 text-right control-label col-form-label">File</label>
                <div class="col-sm-9">
                  <input type="file" class="form-control {{ $errors->has('file_name') ? ' is-invalid' : '' }}" id="filename" name="file_name" required >
                  @if ($errors->has('file_name'))
                    <span class="invalid-feedback">
                                              <strong>{{ $errors->first('file_name') }} </strong>
                                            </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="border-top">
              <div class="card-body">
                <button type="submit" class="btn btn-primary">Submit</button>
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

  <!--====================================== #modal-dialog ========================================-->
  <div class="modal fade" id="modal-dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Information</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <h3>
            Check if your manuscript meet the requirements.</h3>
            
           <p> How to *submit a manuscript:</p>

<h4>What we need from you as part of the manuscript:</h4>

<ul>
<li> A cover page with the following details:</li>

<li>Your full name and surname</li>
<li>Your contact details - email and cell number</li>
<li>A short biography of who you are</li>
<li>A short synopsis of the manuscript</li>
<li>A list of previous publications if applicable</li>
<li>A complete manuscript in word or pdf format</li>
<li>All manuscripts must be spell checked before submission.</li>
</u>
<p>*If you do not have a full manuscript, do not worry! You may submit the first 3 chapters of your book.*</p>
          </p>
          
        </div>
        <div class="modal-footer">
          <a href="javascript:;" class="btn btn-white" id="delete-user" data-dismiss="modal">Yes</a>
        </div>
      </div>
    </div>
  </div>
  <!-- #modal-without-animation -->


  <script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
  <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>

  <script>

      $( document ).ready(function() {
          $('#modal-dialog').modal('show');
      });


  </script>
  @endsection