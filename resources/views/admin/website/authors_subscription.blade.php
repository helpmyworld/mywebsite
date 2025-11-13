@extends('layouts.adminLayout.admin_design')

@section('content')

    <!-- begin #content -->
    <div id="content">
    @include('layouts.response')
    <!-- begin breadcrumb -->
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Subscription</a> <a href="#" class="current">View</a> </div>
            <h1>Active Subscription</h1>
        </div>

        <!-- end breadcrumb -->


        <!-- begin row -->
        <div class="container-fluid"><hr>
            <!-- end #content -->
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Authors Subscription</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>

                                <tr>
                                    <th width="1%">ID</th>
                                    <th class="text-nowrap">Subscription Name</th>
                                    <th class="text-nowrap">Author Name</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Start Date</th>
                                    <th class="text-nowrap">Next Billing Date</th>
                                    <th class="text-nowrap">Action</th>

                                </tr>

                                </thead>
                                <tbody>
                                @foreach($subscriptions as $row)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="f-s-600 text-inverse">{{$row->id}}</td>
                                        <td>{{$row->subscription_name}}</td>
                                        <td>{{$row->user->name}}</td>
                                        <td>{{$row->status}}</td>
                                        <td>{{$row->start_date}}</td>
                                        <td>{{$row->getNextSubscriptionBillingDate()}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="span6">
                                                    <a href="#cancel-dialog"  data-id = "{{$row->id}}"  data-toggle="modal" style="width:100%"   class="btn btn-danger btn-xs cancel-modal">Cancel  </a>

                                                </div>
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
    </div>


    <!--====================================== #modal-dialog ========================================-->
    <div class="modal fade" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Subscription</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to delete this Subscription
                    </p>
                    <form id="delete-form" action="" method="post">
                        {{csrf_field()}}
                        @method('DELETE')
                        {{ method_field('DELETE') }}
                        <input type="hidden"  name="id" id="subscription-id" value="1">
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

    <!--====================================== #modal-dialog ========================================-->
    <div class="modal fade" id="cancel-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cancel Subscription</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to cancel your subscription
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white"  data-dismiss="modal">Close</a>
                    <form action="{{route('admin.subscription.authors.destroy')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden"  name="id" id="sub-id" value="1">
                        <input type="submit" class="btn btn-danger" id="cancel" value="Cancel">
                    </form>
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
            $('#subscription-id').val(id);

            //set form action
            $('#delete-form').attr('action',"{{url('/admin/subscriptions')}}/"+id)
            $('#modal-dialog').modal('show');

        });

        $('.cancel-modal').on('click', function () {
            var user_id = $(this).attr('data-id');
            $('#admin-id').val(user_id);
            $('#modal-dialog').modal('show');

        });



    </script>

@endsection
