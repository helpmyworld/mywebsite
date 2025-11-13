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
                    <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!--=============================================
=            Forgot Password page content       =
==============================================-->
<main class="page-section inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-sm-12 col-md-8 col-lg-6 col-xs-12">
                <div class="login-form">
                    <h4 class="login-title">Forgot Password</h4>
                    <p><span class="font-weight-bold">Enter your email address below and we’ll send you a password reset link.</span></p>

                    {{-- Success / Error Messages --}}
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

                    {{-- Forgot Password Form --}}
                    <form id="forgotPasswordForm" name="forgotPasswordForm" method="POST" action="{{ url('/forgot-password') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb--20">
                                <label for="email">Email Address</label>
                                <input id="email" name="email" type="email" class="form-control mb-0" placeholder="Enter your email address" required>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-outlined btn--primary w-100">Request Reset Link</button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt--20">
                        <a href="{{ url('/login') }}" class="font-weight-bold">Back to Login</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
