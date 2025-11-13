@extends('layouts.adminLayout.admin_design')
@section('content')

<style>
  /* Scoped to this page only */
  .tags-page .toolbar {
    display:flex; align-items:center; gap:16px; justify-content:space-between; flex-wrap:wrap;
    padding:12px 16px; border-bottom:1px solid #eee; background:#fafafa;
  }
  .tags-page .toolbar-left { display:flex; align-items:center; gap:12px; }
  .tags-page .toolbar-actions { display:flex; align-items:center; gap:8px; }
  .tags-page .form-inline .form-control { height:30px; line-height:30px; }
  .tags-page .form-inline .btn { height:30px; line-height:18px; padding:5px 10px; }
  .tags-page .table th, .tags-page .table td { vertical-align:middle; }
  .tags-page .table th { white-space:nowrap; }
  .tags-page .table .center { text-align:center; }
  .tags-page .deleteRecord.btn { margin:0; }
  #bulkDeleteBtn[disabled] { opacity:.6; cursor:not-allowed; }
  @media (max-width: 640px) {
    .tags-page .toolbar { align-items:stretch; }
    .tags-page .toolbar-left { width:100%; justify-content:space-between; }
    .tags-page .form-inline { width:100%; display:flex; gap:6px; }
    .tags-page .form-inline .input-group { display:flex; width:100%; }
    .tags-page .form-inline .form-control { flex:1 1 auto; max-width:none !important; }
  }
</style>

<div id="content" class="tags-page">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <a href="#">Tags</a>
      <a href="#" class="current">View Tags</a>
    </div>
    <h1>Tags</h1>

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
    {{-- Toolbar: title | add form | bulk delete --}}
    <div class="widget-title toolbar">
      <div class="toolbar-left">
        <span class="icon"><i class="icon-tags"></i></span>
        <h4 style="margin:0;">Tags</h4>
      </div>

      {{-- Add Tag (unchanged route & fields) --}}
      <form class="form-inline" method="POST" action="{{ route('tags.store') }}">
        @csrf
        <div class="input-group">
          <input
            type="text"
            class="form-control form-control-sm"
            name="name"
            placeholder="Enter tag name"
            value="{{ old('name') }}"
            required
            style="max-width:220px;"
          >
          <button type="submit" class="btn btn-success btn-sm" style="margin-left:6px;">
            Add Tag
          </button>
        </div>
        @error('name')
          <div class="invalid-feedback d-block text-danger small" style="margin-top:6px;">{{ $message }}</div>
        @enderror
      </form>

      <div class="toolbar-actions">
        <button type="submit"
                form="bulkDeleteForm"
                id="bulkDeleteBtn"
                class="btn btn-danger btn-mini"
                disabled
                onclick="return confirm('Delete selected tags?')">
          <i class="icon-trash"></i> Delete Selected
        </button>
      </div>
    </div>

    <div class="widget-content nopadding">
      <!-- Bulk delete form wraps the table (POST, like users) -->
      <form id="bulkDeleteForm" method="post" action="{{ url('/admin/tags/bulk-delete') }}">
        {{ csrf_field() }}

        <table class="table table-bordered data-table">
          <thead>
            <tr>
              <th style="width:36px;" class="center">
                <label style="margin:0;">
                  <input type="checkbox" id="select_all">
                </label>
              </th>
              <th style="width:80px;">ID</th>
              <th>Name</th>
              <th>Created At</th>
              <th style="width:220px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($tags as $tag)
              <tr class="gradeX">
                <td class="center">
                  <input type="checkbox" name="ids[]" value="{{ $tag->id }}" class="row_check">
                </td>
                <td class="center">{{ $tag->id }}</td>
                <td>{{ $tag->name }}</td>
                <td class="center">{{ $tag->created_at }}</td>
                <td class="center">
                  <a id="delTag" rel="{{ $tag->id }}" rel1="delete-tag" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="center">No tags found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        
      </form>
    </div>
  </div>
</div>

<!-- Minimal inline JS: select-all + enable button (unchanged logic) -->
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
@endsection
