@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home...="#">Users</a> <a href="#" class="current">View Users</a> </div>
    <h1>Users</h1>
    @if(Session::has('flash_message_error'))
      <div class="alert alert-error alert-block">
          <button type="button" class="close" data-dismiss="alert"></button> 
              <strong>{!! session('flash_message_error') !!}</strong>
      </div>
    @endif   
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert"></button> 
                <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif
  </div>

  <!-- Top actions: Export | Add Users | Delete Selected -->
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div style="display:flex; justify-content:space-between; align-items:center; margin: 0 0 10px 0;">
          <div>
            <a href="{{ url('/admin/export-users') }}" class="btn btn-primary btn-mini">Export</a>
          </div>
          <div style="display:flex; gap:10px;">
            <a href="{{ url('/admin/add-users') }}" class="btn btn-success" style="font-size:14px; padding:10px 18px;">
              Add Users
            </a>
            <!-- Bulk delete submit button (disabled until selection) -->
            <button type="submit" form="bulkDeleteForm" id="bulkDeleteBtn" class="btn btn-danger" disabled
                    style="font-size:14px; padding:10px 18px;">
              Delete Selected
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Users</h5>
          </div>
          <div class="widget-content nopadding">
            <!-- Bulk delete form wraps the table -->
            <form id="bulkDeleteForm" method="post" action="{{ url('/admin/users/bulk-delete') }}">
              {{ csrf_field() }}

              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th style="width:32px; text-align:center;">
                      <input type="checkbox" id="select_all" />
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Bio</th>
                    <th>Featured</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  <tr class="gradeX">
                    <td class="center" style="text-align:center;">
                      <input type="checkbox" class="row_check" name="ids[]" value="{{ $user->id }}">
                    </td>
                    <td class="center">{{ $user->name }}</td>
                    <td class="center">{{ $user->email }}</td>
                    <td class="center">{{ $user->type }}</td>
                    <td class="center">{{ $user->bio }}</td>
                    <td class="center">
                      @if(isset($user->featured_author) && $user->featured_author)
                        <span style="color:green">Yes</span>
                      @else
                        <span style="color:red">No</span>
                      @endif
                    </td>
                    <td class="center">
                      @php
                        $imgFile = $user->profile_image ?? null;
                        $imgSrc = null;
                        if ($imgFile && file_exists(public_path('images/backend_images/authors/medium/'.$imgFile))) {
                          $imgSrc = asset('images/backend_images/authors/medium/'.$imgFile);
                        } elseif ($imgFile && file_exists(public_path('images/backend_images/authors/large/'.$imgFile))) {
                          $imgSrc = asset('images/backend_images/authors/large/'.$imgFile);
                        } elseif ($imgFile && file_exists(public_path('images/users/'.$imgFile))) {
                          $imgSrc = asset('images/users/'.$imgFile);
                        }
                      @endphp
                      @if($imgSrc)
                        <img src="{{ $imgSrc }}" alt="{{ $user->name }}" style="width:60px;">
                      @else
                        N/A
                      @endif
                    </td>
                    <td class="center">{{ $user->created_at }}</td>
                    <td class="center">
                      <a href="{{ url('/admin/edit-user/'.$user->id) }}" class="btn btn-info btn-mini">Edit</a>
                      <a id="delProduct" rel="{{ $user->id }}" rel1="delete-user" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Minimal inline JS to handle select-all and button state -->
<script>
  (function(){
    var selectAll = document.getElementById('select_all');
    var checks    = document.getElementsByClassName('row_check');
    var btn       = document.getElementById('bulkDeleteBtn');

    function updateButton() {
      var anyChecked = false;
      for (var i=0; i<checks.length; i++) {
        if (checks[i].checked) { anyChecked = true; break; }
      }
      if (btn) btn.disabled = !anyChecked;
    }

    if (selectAll) {
      selectAll.addEventListener('change', function(){
        for (var i=0; i<checks.length; i++) {
          checks[i].checked = selectAll.checked;
        }
        updateButton();
      });
    }

    for (var i=0; i<checks.length; i++) {
      checks[i].addEventListener('change', updateButton);
    }
    updateButton();
  })();
</script>

@endsection
