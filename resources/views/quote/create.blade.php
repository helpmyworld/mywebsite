@extends('layouts.frontLayout.front_design')
@section('title', 'Request a Quote — Help My World Publishing')
@section('meta_description', 'Tell us about your project to receive a custom publishing quote.')

@section('content')
<div class="container py-4">
  <h1 class="mb-3">Request a Quote</h1>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('quote.store') }}" class="row g-3">
    @csrf
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
      @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label class="form-label">Phone (optional)</label>
      <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Project Type</label>
      <select name="project_type" class="form-control" required>
        <option value="">Select...</option>
        <option {{ old('project_type')==='Children\'s Book' ? 'selected' : '' }}>Children's Book</option>
        <option {{ old('project_type')==='Fiction' ? 'selected' : '' }}>Fiction</option>
        <option {{ old('project_type')==='Non-fiction' ? 'selected' : '' }}>Non-fiction</option>
        <option {{ old('project_type')==='Poetry' ? 'selected' : '' }}>Poetry</option>
        <option {{ old('project_type')==='Memoir' ? 'selected' : '' }}>Memoir</option>
        <option {{ old('project_type')==='Other' ? 'selected' : '' }}>Other</option>
      </select>
      @error('project_type') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label class="form-label">Budget (optional)</label>
      <input type="text" name="budget" value="{{ old('budget') }}" class="form-control" placeholder="e.g., R10,000 – R25,000">
    </div>
    <div class="col-12">
      <label class="form-label">Tell us about your project</label>
      <textarea name="message" rows="6" class="form-control" required>{{ old('message') }}</textarea>
      @error('message') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
      <button class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
@endsection
