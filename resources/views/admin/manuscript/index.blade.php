@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Users</a> <a href="#" class="current">View Users</a> </div>
    <h1>Users</h1>
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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Users</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Progress</th>
                  <th>Uploaded By</th>
                  <th>Uploaded On</th>
                  <th>Action On</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($manuscripts as $row)
                <tr class="gradeX">
                  <td class="center">{{ $row->id }}</td>
                  <td class="center">{{ $row->title }}</td>
                  <td class="center">{{ $row->status }}</td>
                  <td class="center">{{ $row->user->name }}</td>
                  <td class="center">{{ $row->created_at }}</td>
                  <td>
                    <div class="col-md-6">
                      <a href="{{route('admin.manuscripts.show',['id' => $row->id])}}" class="btn btn-success">
                        View
                      </a>
                    </div>
                    <div class="col-md-6">
                      <a href="#"  data-id = "{{$row->id}}"  style="width:100%" title="Delete"   class="btn btn-danger trigger-modal"> Delete </a>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--====================================== #modal-dialog ========================================-->
<div class="modal fade" id="modal-dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Manuscript</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <p>
          Are you sure you want to delete this Manuscript
        </p>
        <form id="delete-form" action="" method="post">
          {{csrf_field()}}
          @method('DELETE')
          {{ method_field('DELETE') }}
          <input type="hidden"  name="id" id="manuscript-id" value="1">
          <input type="submit" class="btn btn-danger" id="delete" value="Delete">
        </form>
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white"  data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>
<!-- #modal-without-animation -->

<script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
<script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
<script>

    $('.trigger-modal').on('click', function () {
        var id = $(this).attr('data-id');
        $('#manuscript-id').val(id);

        //set form action
        $('#delete-form').attr('action',"{{url('/admin/manuscripts')}}/"+id)
        $('#modal-dialog').modal('show');

    });

</script>
@endsection
