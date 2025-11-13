@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="container-fluid">
  <h1 class="mb-3">Users</h1>

  <form method="get" class="row g-2 mb-3">
    <div class="col-md-3">
      <input type="text" name="s" value="{{ request('s') }}" class="form-control" placeholder="Search name or email">
    </div>
    <div class="col-md-3">
      <select name="role" class="form-control">
        <option value="">All Roles</option>
        <option value="author" {{ request('role')==='author'?'selected':'' }}>Authors</option>
        <option value="customer" {{ request('role')==='customer'?'selected':'' }}>Customers</option>
        <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admins</option>
      </select>
    </div>
    <div class="col-md-2 form-check" style="padding-top: .5rem;">
      <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ request('featured')?'checked':'' }}>
      <label class="form-check-label" for="featured">Featured authors</label>
    </div>
    <div class="col-md-2">
      <select name="sort" class="form-control">
        <option value="created_at" {{ request('sort')==='created_at'?'selected':'' }}>Sort by Latest</option>
        <option value="role" {{ request('sort')==='role'?'selected':'' }}>Sort by Role</option>
        <option value="name" {{ request('sort')==='name'?'selected':'' }}>Sort by Name</option>
        <option value="email" {{ request('sort')==='email'?'selected':'' }}>Sort by Email</option>
      </select>
    </div>
    <div class="col-md-1">
      <select name="dir" class="form-control">
        <option value="desc" {{ request('dir')==='desc'?'selected':'' }}>Desc</option>
        <option value="asc" {{ request('dir')==='asc'?'selected':'' }}>Asc</option>
      </select>
    </div>
    <div class="col-md-1">
      <button class="btn btn-primary w-100">Filter</button>
    </div>
  </form>

  <div class="mb-3">
    <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Featured</th>
          <th>Joined</th>
          <th width="160">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
        <tr>
          <td>{{ $u->id }}</td>
          <td>{{ $u->name }}</td>
          <td>{{ $u->email }}</td>
          <td><span class="badge bg-secondary text-uppercase">{{ $u->role }}</span></td>
          <td>
            @if($u->role === 'author')
              {!! $u->featured_author ? '<span class="badge bg-success">Featured</span>' : '<span class="badge bg-light text-dark">No</span>' !!}
            @else
              <span class="badge bg-light text-dark">N/A</span>
            @endif
          </td>
          <td>{{ $u->created_at?->format('Y-m-d') }}</td>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('users.edit', $u->id) }}">Edit</a>
            <form action="{{ route('users.destroy', $u->id) }}" method="post" class="d-inline"
                  onsubmit="return confirm('Delete this user? This cannot be undone.');">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7">No users found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $users->links() }}
</div>
@endsection
