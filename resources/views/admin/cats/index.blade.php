@extends('layouts.adminLayout.admin_design')

@section('content')

    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Post Categories</a>
                <a href="#" class="current">Add Post Category</a> </div>
            <h1>Post Categories</h1>
            @if(Session::has('flash_message_error'))
                <div class="alert alert-error alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
        </div>
        <div class="widget-box">
 <div class="widget-title" style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
  <!-- Left: Title -->
  <div class="d-flex align-items-center">
     <h4 style="margin: 0;">Categories</h4>
    <span class="icon" style="margin-right: 8px;"><i class="icon-hand-right"> </i></span>
    <br><br>
  </div>

  <!-- Right: Add Category Form -->
  <form class="form-inline d-flex align-items-center" method="POST" action="{{ route('cats.store') }}">
    @csrf
    <div class="input-group">
      <input type="text"
             class="form-control form-control-sm"
             name="name"
             placeholder="Enter category name"
             value="{{ old('name') }}"
             required
             style="max-width: 220px;">

      <button type="submit" class="btn btn-success btn-sm" style="margin-left: 6px;">
        Add Category
      </button>

      <br>

      <button type="submit"
                form="bulkDeleteForm"
                id="bulkDeleteBtn"
                class="btn btn-danger btn-mini"
                disabled
                onclick="return confirm('Delete selected categories?')">
          <i class="icon-trash"></i> Delete Selected
        </button>
    </div>
    @error('name')
      <div class="invalid-feedback d-block text-danger small">{{ $message }}</div>
    @enderror
  </form>
</div>

  <div class="widget-content nopadding">

    <!-- BULK FORM: keep it separate (no nesting!) -->
    <form id="bulkDeleteForm" method="post" action="{{ url('/admin/cats/bulk-delete') }}">
      {{ csrf_field() }}
    </form>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <!-- select-all checkbox column -->
          <th style="width:36px;" class="center">
            <label style="margin:0;">
              <input type="checkbox" id="select_all" form="bulkDeleteForm">
            </label>
          </th>
          <th style="width:80px;">ID</th>
          <th>Name</th>
          <th style="width:200px;">Created</th>
          <th style="width:220px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($cats as $cat)
          <tr>
            <!-- per-row checkbox bound to bulk form -->
            <td class="center">
              <input type="checkbox" name="ids[]" value="{{ $cat->id }}" class="row_check" form="bulkDeleteForm">
            </td>
            <td class="center">{{ $cat->id }}</td>
            <td>{{ $cat->name }}</td>
            <td>{{ optional($cat->created_at)->format('Y-m-d H:i') }}</td>
            <td>
              {{-- Show --}}
              <a href="{{ route('cats.show', $cat) }}" class="btn btn-info btn-mini">View</a>

              {{-- Edit --}}
              <a href="{{ route('cats.edit', $cat) }}" class="btn btn-primary btn-mini">Edit</a>

              {{-- Delete (single) --}}
              <form action="{{ route('cats.destroy', $cat) }}"
                    method="POST"
                    style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn btn-danger btn-mini"
                        onclick="return confirm('Delete this category?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted">No categories yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

<!-- Minimal inline JS: select-all + enable button -->
<script>
  (function(){
    var selectAll = document.getElementById('select_all');
    var checks    = document.getElementsByClassName('row_check');
    var btn       = document.getElementById('bulkDeleteBtn');

    function updateButton() {
      var any = false;
      for (var i=0; i<checks.length; i++) { if (checks[i].checked) { any = true; break; } }
      if (btn) btn.disabled = !any;
    }

    if (selectAll) {
      selectAll.addEventListener('change', function(){
        for (var i=0; i<checks.length; i++) { checks[i].checked = selectAll.checked; }
        updateButton();
      });
    }

    for (var i=0; i<checks.length; i++) { checks[i].addEventListener('change', updateButton); }
    updateButton();
  })();
</script>

{{-- Pagination --}}
@if(method_exists($cats, 'links'))
  <div class="row">
    <div class="col-md-8">
      {{ $cats->links() }}
    </div>
  </div>
@endif
    </div>

@stop
