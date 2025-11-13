@extends('layouts.frontLayout.front_design')
@section('title', 'Page Not Found — Help My World Publishing')
@section('meta_description', 'We couldn\'t find the page you were looking for.')

@section('content')
<div class="container py-5 text-center">
  <h1 class="display-5">Page not found</h1>
  <p class="lead mb-4">The page you’re after may have moved or no longer exists.</p>
  <a href="{{ url('/') }}" class="btn btn-primary">Go to Home</a>
</div>
@endsection
