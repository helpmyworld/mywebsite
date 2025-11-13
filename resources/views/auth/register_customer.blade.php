@extends('layouts.frontLayout.front_design')

@section('content')
<div class="container" style="max-width:480px;margin-top:40px;">
    <h3>Create Customer Account</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin-bottom:0;">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register.customer.store') }}">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input name="name" type="text" value="{{ old('name') }}" class="form-control" required>
        </div>
        <div class="form-group" style="margin-top:10px;">
            <label>Email</label>
            <input name="email" type="email" value="{{ old('email') }}" class="form-control" required>
        </div>
        <div class="form-group" style="margin-top:10px;">
            <label>Password</label>
            <input name="password" type="password" class="form-control" required>
        </div>
        <div class="form-group" style="margin-top:10px;">
            <label>Confirm Password</label>
            <input name="password_confirmation" type="password" class="form-control" required>
        </div>
        <div style="margin-top:10px;">
          
        </div>
        <button type="submit" class="btn btn-success" style="margin-top:15px;">Register</button>
    </form>
</div>
@endsection

