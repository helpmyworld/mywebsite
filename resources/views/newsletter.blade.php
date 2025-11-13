@extends('layouts.frontLayout.front_design')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ url('newsletter') }}" method="POST" class="searchform">
        @csrf
        <input type="email" name="email" required placeholder="Your email address" />
        <button type="submit" class="btn btn-default">
            <i class="fa fa-arrow-circle-o-right"></i>
        </button>
        <p class="mt-2">Subscribe for author tips, promotions, and new releases.</p>
        @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
    </form>
@endsection
