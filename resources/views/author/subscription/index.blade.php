@extends('layouts.authorLayout.author_design')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Subscription</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Subscription</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0">My Subscriptions</h5>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th class="col">Start Date </th>
                            <th class="col">Next Billing date </th>
                            <th class="col">Status </th>
                            {{--<th class="col">Action</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscriptions as $row)
                            <tr class="odd gradeX">
                                <td>
                                    {{$row->id}}

                                </td>
                                <td>
                                    {{$row->subscription_name}}

                                </td>
                                <td>
                                    {{$row->start_date}}

                                </td>
                                <td>
                                    {{$row->getNextSubscriptionBillingDate()}}

                                </td>
                                <td>
                                    {{$row->status}}

                                </td>
                                {{--<td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#modal-dialog"  data-id = "{{$row->id}}"  data-toggle="modal" style="width:100%"   class="btn btn-danger btn-xs trigger-modal">Cancel  </a>

                                        </div>
                                    </div>

                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    <!--====================================== #modal-dialog ========================================-->
    <div class="modal fade" id="modal-dialog">
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
                    <a href="javascript:;" class="btn btn-white" id="delete-user" data-dismiss="modal">Close</a>
                    <form action="{{route('author.subscriptions.cancel')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden"  name="id" id="admin-id" value="1">
                        <input type="submit" class="btn btn-danger" id="remove" value="Cancel">
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
            var user_id = $(this).attr('data-id');
            $('#admin-id').val(user_id);
            $('#modal-dialog').modal('show');

        });



    </script>

@endsection
