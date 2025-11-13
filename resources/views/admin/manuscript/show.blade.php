@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Manuscript</a> <a href="#" class="current">View</a> </div>
    <h1>Manuscript</h1>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Manuscript Detail</h5>
          </div>
          <div class="widget-content nopadding">
            <form  class="form-horizontal" >
              <div class="control-group">
                <label class="control-label">Title</label>
                <label class="control-label">{{ $manuscript->title }}</label>
              </div>
              <div class="control-group">
                <label class="control-label">Progress</label>
                <label class="control-label text-success">{{ $manuscript->status }}</label>
              </div>
              <div class="control-group">
                <label class="control-label">Uploaded By</label>
                  <label class="control-label">{{ $manuscript->user->name }} &nbsp&nbsp&nbsp @if($manuscript->user->active_subscription())<span style="color:red;">Subscribed to {{$manuscript->user->active_subscription()->subscription_name}} </span>@else @endif @if($manuscript->user->premium_subscription())<span style="color:green;">&nbsp Premium User</span>@else @endif</label>
              </div>
              <div class="control-group">
                <label class="control-label">Uploaded At</label>
                <label class="control-label">{{ $manuscript->created_at }}</label>
              </div>
                @if($manuscript->accepted_comment)
                    <div class="control-group">
                        <label class="control-label">Accepted Comment</label>
                        <label class="control-label">{{ $manuscript->accepted_comment }}</label>
                    </div>
                @endif
                @if($manuscript->rejected_comment)
                    <div class="control-group">
                        <label class="control-label">Rejected Comment</label>
                        <label class="control-label">{{ $manuscript->rejected_comment }}</label>
                    </div>
                @endif
              <div class="control-group">
                <label class="control-label">Manuscript</label>
                <div class="controls">
                  <div class="uploader" id="uniform-undefined"><a href="/uploads/manuscript/{{$manuscript->file_name}}" target="-_blank" class="btn btn-success">Download</a></div>
                </div>
              </div>
             
              <div class="form-actions">
                <a href="#UpdateProject" data-toggle="modal"      class="btn btn-success"> Update Progress</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Update Project Status Modal -->
<div class="modal my-modal fade" id="UpdateProject" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Project Status</h4>
        {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <form id="update-project-status-form" action="{{route('admin.manuscripts.update',['id' => $manuscript->id])}}" enctype="multipart/form-data" method="POST">
            @csrf
              @method('PUT')

            <div class="control-group" style="z-index: 999999999999 !important;">
              <select class="form-control" name="status" id="manuscript-status-select" >
                <option disabled selected>Select Project Status</option>
                  <option value="Accepted">Accepted</option>
                <option value="Rejected">Rejected</option>
                <option value="Editing">Editing</option>
                <option value="Book Cover">Book Cover</option>
                <option value="Published">Published</option>
              </select>
            </div>

              <div style="margin-top: 20px"></div>
              <div id="update-status-template-content-area" style="width: 100%">
              </div>

              <div style="margin-top: 20px"></div>

              <button type="submit" class="btn btn-success" >Update</button>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
<script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
<script>
    //handle project status select changes
    $('#manuscript-status-select').click(function () {

        var selectedVal = $(this).val();

        if(selectedVal == 'Accepted'){
            $('#update-status-template-content-area').html(createAcceptedEL());


        }
        else if(selectedVal == 'Rejected'){
            $('#update-status-template-content-area').html(createRejectedEL());
        }
        else{
            $('#update-status-template-content-area').html('');
        }
    });

    var createAcceptedEL = function() {
        var text = $('#accepted-status-template').text();
        var el = $(text);
        return el;
    }

    var createRejectedEL = function() {
        var text = $('#rejected-status-template').text();
        var el = $(text);
        return el;
    }


</script>
<script id="accepted-status-template" type="text/template">
    <div class="control-group">
            <textarea class="form-control" rows="6"style="width: 400px"  name="comment" placeholder="Enter Acceptance Comment"></textarea>
    </div>
    <div class="control-group">
        <input class="form-control" style="width: 400px"  name="cost" placeholder="Enter cost if user is not premium">
    </div>
</script>
<script id="rejected-status-template" type="text/template">
    <div class="control-group">
        <textarea class="form-control" rows="6"style="width: 400px"  name="comment" placeholder="Enter Rejected Comment"></textarea>

    </div>
</script>
@endsection

