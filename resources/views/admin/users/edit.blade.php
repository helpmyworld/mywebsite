@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="container-fluid">
  <h1 class="mb-3">Add User</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('users.store') }}">
    @csrf

    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Role</label>
      <select class="form-control" name="role" required>
        <option value="customer" {{ old('role')==='customer'?'selected':'' }}>Customer</option>
        <option value="author"   {{ old('role')==='author'?'selected':'' }}>Author</option>
        <option value="admin"    {{ old('role')==='admin'?'selected':'' }}>Admin</option>
      </select>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="featured_author" name="featured_author" value="1" {{ old('featured_author') ? 'checked' : '' }}>
      <label class="form-check-label" for="featured_author">
        Featured Author
      </label>
      <div class="form-text">Only applies when role is “Author”.</div>
    </div>

    <button class="btn btn-primary">Create</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
