@extends('layouts.frontLayout.front_design')

@section('content')

    {{-- ======= Breadcrumb (Pustok) ======= --}}
    <section class="breadcrumb-section" style="margin-top:20px;">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Login / Register</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- ======= Flash Messages ======= --}}
    <div class="container" style="margin-top:10px;">
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
    </div>

    {{-- ======= Login / Register ======= --}}
    <main class="page-section inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row">

                {{-- ======= Left: LOGIN ======= --}}
                <div class="col-sm-12 col-md-12 col-lg-6 mb--30 mb-lg--0">
                    <form id="loginForm" name="loginForm" action="{{ url('/user-login') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="login-form">
                            <h4 class="login-title">Login to your account</h4>
                            <p><span class="font-weight-bold">I am a returning customer</span></p>
                            <div class="row">
                                <div class="col-md-12 col-12 mb--15">
                                    <label for="login_email">Email Address</label>
                                    <input class="mb-0 form-control" name="email" id="login_email" type="email" placeholder="Email Address" />
                                </div>
                                <div class="col-12 mb--20">
                                    <label for="login_password">Password</label>
                                    <input class="mb-0 form-control" name="password" id="login_password" type="password" placeholder="Password" />
                                </div>
                                <div class="col-md-12 d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-outlined">Login</button>
                                    <a href="{{ url('forgot-password') }}" class="btn btn--primary" style="margin-left:10px;">
                                        Forgot Password?
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- ======= Right: REGISTER ======= --}}
                <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                    <form id="registerForm" name="registerForm" action="{{ url('/user-register') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="login-form">
                            <h4 class="login-title">New User Signup!</h4>

                            {{-- Validation errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="reg-name">Name</label>
                                <input type="text" class="form-control" id="reg-name" name="name"
                                       value="{{ old('name') }}" required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="reg-email">Email</label>
                                <input type="email" class="form-control" id="reg-email" name="email"
                                       value="{{ old('email') }}" required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="reg-password">Password</label>
                                <input type="password" class="form-control" id="reg-password" name="password" required>
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- Cloudflare Turnstile --}}
                            <div class="form-group">
                                <div class="cf-turnstile" data-sitekey="{{ config('turnstile.site_key') }}"></div>
                                @if ($errors->has('cf-turnstile-response'))
                                    <span class="text-danger">{{ $errors->first('cf-turnstile-response') }}</span>
                                @endif
                            </div>

                            {{-- Optional: register as Author (kept as in your original) --}}
                            <div class="form-group">
                                <label class="d-inline-flex align-items-center">
                                    <input type="checkbox" name="type" value="Author" style="margin-right:8px;">
                                    Tick to register as an Author
                                </label>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>

    {{-- Load Turnstile script inline to avoid @stack() issues --}}
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

@endsection
