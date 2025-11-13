@extends('layouts.authorLayout.author_design')
@section('content')
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Profile</h4>
        <div class="ml-auto text-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
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
      @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{!! session('flash_message_success') !!}</strong>
        </div>
      @endif
      @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block" style="background-color:#f4d2d2">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{!! session('flash_message_error') !!}</strong>
        </div>
      @endif
      <div class="col-md-12">
        <div class="card">
          <form class="form-horizontal" action="{{ route('author.update-profile') }}" method="POST">
            @csrf
            <div class="card-body">
              <h4 class="card-title">Update Profile</h4>
              <div class="form-group row">
                <input value="{{ $user->email }}" class="form-control" readonly="" />
              </div>

              <div class="form-group row">
                <input value="{{ $user->name }}" class="form-control" id="name" name="name" type="text" placeholder="Name"/>
              </div>
              <div class="form-group row">
                <input value="{{ $user->address }}" class="form-control" id="address" name="address" type="text" placeholder="Address"/>
              </div>

              <div class="form-group row">
                <input value="{{ $user->city }}" id="city" class="form-control" name="city" type="text" placeholder="City"/>
              </div>

              <div class="form-group row">
                <input value="{{ $user->state }}" class="form-control" id="state" name="state" type="text" placeholder="Province"/>
              </div>

              <div class="form-group row">
                <select id="country" name="country" class="form-control">
                  @if($user->country)
                    <option value="{{$user->country}}">{{$user->country}}</option>
                    @else
                    <option value="" selected disabled>Select Country</option>
                    @endif
                  @foreach($countries as $country)
                    <option value="{{ $country->country_name }}">{{ $country->country_name }}</option>
                  @endforeach
               </select>
              </div>
              <div class="form-group row">
                <input value="{{ $user->pincode }}" class="form-control" id="pincode" name="pincode" type="text" placeholder="Postal Code"/>
              </div>

              <div class="form-group row">
                <input value="{{ $user->mobile }}" class="form-control" id="mobile" name="mobile" type="text" placeholder="Mobile"/>
              </div>

              <div class="form-group row">
                <textarea name="bio" class="form-control" rows="10" placeholder="Please write your bio here">{{ $user->bio }}</textarea>
              </div>

              <div class="form-group row">
                <input value="{{ $user->facebook }}" class="form-control" id="facebook" name="facebook" type="text" placeholder="Facebook Profile URL"/>
              </div>
              <div class="form-group row">
                <input value="{{ $user->twitter }}" class="form-control" id="twitter" name="twitter" type="text" placeholder="Twitter Profile URL"/>
              </div>
              <div class="form-group row">
                <input value="{{ $user->gplus }}" class="form-control" id="twitter" name="gplus" type="text" placeholder="Gplus Profile URL"/>
              </div>
              <div class="form-group row">
                <input value="{{ $user->linkln }}" class="form-control" id="linkln" name="linkln" type="text" placeholder="LinkedIn Profile URL"/>
              </div>

            </div>
            <div class="border-top">
              <div class="card-body">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <table id="data-table-combine" class="table table-striped table-bordered">
            <thead>

            <tr>
              <th class="text-nowrap">Profile Image</th>
              <th class="text-nowrap">Action</th>
            </tr>

            </thead>
            <tbody>
            <tr>
              <td width="1%" class="with-img">
                <img src="/uploads/profile/{{$user->profile_image}}" height="120" />
              </td>
              <td>
                <form enctype="multipart/form-data" id="form-edit-sub-image" action="{{route('author.update-profile-image')}}" method="POST">
                  <input type="hidden" name="user_id" value="{{$user->id}}">
                  {{csrf_field()}}
                  <div class="form-group">
                    <input type="file" name="image" class="form-control"/>
                  </div>
                  <div class="form-group">
                    <input type="submit" value="Upload" class="btn btn-primary">
                  </div>

                </form>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <form class="form-horizontal" action="{{ route('author.update-password') }}" method="POST">
            @csrf
            <div class="card-body">
              <h4 class="card-title">Update Password</h4>
              <div class="form-group row">
                <input type="password" class="form-control" name="new_pwd" id="new_pwd" placeholder="New Password">
              </div>
              <div class="form-group row">
                <input type="password" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password">
              </div>
            </div>
            <div class="border-top">
              <div class="card-body">
                <button type="submit" class="btn btn-primary">Update</button>
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