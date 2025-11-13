@extends('layouts.frontLayout.front_design')
@section('content')

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <h2 class="sr-only">Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Account Section -->
<div class="page-section inner-page-sec-padding">
    <div class="container">
        <div class="row">
            <!-- Account Menu -->
            <div class="col-lg-3 col-12 mb--30 mb-lg--0">
                <div class="myaccount-tab-menu nav flex-column" role="tablist">
                    <a href="#account-info" class="active" data-bs-toggle="tab"><i class="fa fa-user"></i> Account Details</a>
                    <a href="#password-update" data-bs-toggle="tab"><i class="fa fa-lock"></i> Change Password</a>
                    <a href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- Account Content -->
            <div class="col-lg-9 col-12 mt--30 mt-lg--0">
                <div class="tab-content" id="myaccountContent">

                    {{-- Flash Messages --}}
                    @if(Session::has('flash_message_success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_success') !!}</strong>
                        </div>
                    @endif
                    @if(Session::has('flash_message_error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_error') !!}</strong>
                        </div>
                    @endif

                    <!-- Account Details -->
                    <div class="tab-pane fade show active" id="account-info" role="tabpanel">
                        <div class="myaccount-content">
                            <h3>Account Details</h3>
                            <div class="account-details-form">
                                <form id="accountForm" name="accountForm" method="POST" action="{{ url('/account') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb--20">
                                            <label>Email Address</label>
                                            <input type="email" value="{{ $userDetails->email }}" readonly class="form-control">
                                        </div>
                                        <div class="col-md-6 mb--20">
                                            <label>Name</label>
                                            <input type="text" name="name" value="{{ $userDetails->name }}" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="col-md-6 mb--20">
                                            <label>Mobile</label>
                                            <input type="text" name="mobile" value="{{ $userDetails->mobile }}" class="form-control" placeholder="Mobile">
                                        </div>
                                        <div class="col-md-12 mb--20">
                                            <label>Address</label>
                                            <input type="text" name="address" value="{{ $userDetails->address }}" class="form-control" placeholder="Address">
                                        </div>
                                        <div class="col-md-6 mb--20">
                                            <label>City</label>
                                            <input type="text" name="city" value="{{ $userDetails->city }}" class="form-control" placeholder="City">
                                        </div>
                                        <div class="col-md-6 mb--20">
                                            <label>State</label>
                                            <input type="text" name="state" value="{{ $userDetails->state }}" class="form-control" placeholder="State">
                                        </div>
                                        <div class="col-md-6 mb--20">
                                            <label>Country</label>
                                            <select id="country" name="country" class="form-control">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->country_name }}"
                                                        @if($country->country_name == $userDetails->country) selected @endif>
                                                        {{ $country->country_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb--20">
                                            <label>Pincode</label>
                                            <input type="text" name="pincode" value="{{ $userDetails->pincode }}" class="form-control" placeholder="Pincode">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn--primary">Update Account</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Password Update -->
                    <div class="tab-pane fade" id="password-update" role="tabpanel">
                        <div class="myaccount-content">
                            <h3>Change Password</h3>
                            <div class="account-details-form">
                                <form id="passwordForm" name="passwordForm" method="POST" action="{{ url('/update-user-pwd') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mb--20">
                                            <label>Current Password</label>
                                            <input type="password" name="current_pwd" id="current_pwd" class="form-control" placeholder="Current Password">
                                            <span id="chkPwd"></span>
                                        </div>
                                        <div class="col-md-6 mb--20">
                                            <label>New Password</label>
                                            <input type="password" name="new_pwd" id="new_pwd" class="form-control" placeholder="New Password">
                                        </div>
                                        <div class="col-md-6 mb--20">
                                            <label>Confirm Password</label>
                                            <input type="password" name="confirm_pwd" id="confirm_pwd" class="form-control" placeholder="Confirm Password">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn--primary">Update Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Account Content -->
        </div>
    </div>
</div>

@endsection
