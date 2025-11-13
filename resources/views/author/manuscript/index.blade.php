@extends('layouts.authorLayout.author_design')
@section('content')
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Manuscript</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Manuscript</li>
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
          <div class="card-body">
            <h5 class="card-title m-b-0">My Manuscripts</h5>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Progress</th>
              <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($manuscripts as $row)
              <tr>
                <th scope="row">{{$row->id}}</th>
                <td>{{$row->title}}</td>
                <td class="text-success">{{$row->status}}</td>
                <td>
                  <a href="{{route('author.manuscripts.show',['id' => $row->id])}}" class="btn btn-success">View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
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