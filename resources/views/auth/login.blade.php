@extends('layouts.frontLayout.front_design')

@section('content')
<div class="container" style="max-width:480px;margin-top:40px;">
    <h3>Login</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin-bottom:0;">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" value="{{ old('email') }}" class="form-control" required autofocus>
        </div>
        <div class="form-group" style="margin-top:10px;">
            <label>Password</label>
            <input name="password" type="password" class="form-control" required>
        </div>
       
        <div class="form-check" style="margin-top:10px;">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:15px;">Login</button>

        <div style="margin-top:15px;">
            <a href="{{ route('register.customer') }}">Register as Customer</a> |
            <a href="{{ route('register.author') }}">Register as Author</a>
        </div>
    </form>
</div>
@endsection
