@extends('layouts.authorLayout.author_design')
@section('content')
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Dashboard</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
          <div class="box bg-cyan text-center">
            <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
            <h6 class="text-white">Dashboard</h6>
          </div>
        </div>
      </div>

      <!-- NEW: Sales -->
      <div class="col-md-6 col-lg-4 col-xlg-3">
        <a href="{{ route('author.sales.index') }}">
          <div class="card card-hover">
            <div class="box bg-info text-center">
              <h1 class="font-light text-white"><i class="mdi mdi-chart-line"></i></h1>
              <h6 class="text-white">Sales</h6>
            </div>
          </div>
        </a>
      </div>
      <!-- /NEW: Sales -->

      <!-- Column -->
      <div class="col-md-6 col-lg-4 col-xlg-3">
        <a href="{{route('author.questions.create')}}">
          <div class="card card-hover">
            <div class="box bg-success text-center">
              <h1 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h1>
              <h6 class="text-white">Ask a Question</h6>
            </div>
          </div>
        </a>
      </div>
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
        <a href="{{route('author.blogs.create')}}">
          <div class="card card-hover">
            <div class="box bg-warning text-center">
              <h1 class="font-light text-white"><i class="mdi mdi-collage"></i></h1>
              <h6 class="text-white">Post a Blog</h6>
            </div>
          </div>
        </a>
      </div>
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
        <a href="{{route('blog')}}">
          <div class="card card-hover">
            <div class="box bg-warning text-center">
              <h1 class="font-light text-white"><i class="mdi mdi-collage"></i></h1>
              <h6 class="text-white">View Blog/Questions</h6>
            </div>
          </div>
        </a>
      </div>
      <!-- Column -->

    </div>

    @if(auth()->user()->active_subscription())
      <div class="row">
        <div class="col-md-12 col-lg-12 col-xlg-12">
          <div class="card card-hover">
            <div class="box bg-warning text-center">
              <h1 class="font-light text-white">Active Subscription:</h1>
              <h2 class="text-white">{{auth()->user()->active_subscription()->subscription_name}}</h2>
            </div>
          </div>
        </div>
      </div>
    @endif

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title m-b-0">Recent Manuscripts</h5>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Progress</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($manuscripts as $row)
                <tr>
                  <td>{{ $row->title }}</td>
                  <td class="text-success">{{ $row->status }}</td>
                  <td>
                    <a href="{{ route('author.manuscripts.show',['id' => $row->id]) }}" class="btn btn-success">View</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->

  </div>
  <!-- ============================================================== -->
  <!-- End Container fluid  -->
  <!-- ============================================================== -->

@endsection
