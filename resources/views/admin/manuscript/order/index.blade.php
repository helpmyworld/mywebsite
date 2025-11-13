@extends('layouts.adminLayout.admin_design')
@section('content')

    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Manuscript</a> <a href="#" class="current">View Orders</a> </div>
            <h1>Orders</h1>
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
                            <h5>Manuscript Orders</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th width="">ID</th>
                                    <th width="">Payfast ID</th>
                                    <th class="">Ordered by</th>
                                    <th class="">Order Type</th>
                                    <th class="">Order Status</th>
                                    <th class="">Order Cost</th>
                                    <th class="">Date Purchased</th>
                                    <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $row)
                                    <tr class="gradeX">
                                        <td width="1%" class="f-s-600 text-inverse">{{$row->id}}</td>
                                        <td width="1%">{{$row->gateway_payment_id}}</td>
                                        <td>{{$row->user->name}}</td>
                                        <td>{{$row->order_type}}</td>
                                        <td>{{$row->paid ? 'Complete' : 'Cancel'}}</td>
                                        <td>{{$row->order_cost}}</td>
                                        <td>{{$row->date_purchased}}</td>
                                        <td>
                                            <div class="col-md-6">
                                                <a href="{{route('admin.manuscript.orders.show',['id' => $row->id])}}" class="btn btn-success">
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
                    <h4 class="modal-title">Delete Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to delete this Order
                    </p>
                    <form id="delete-form" action="" method="post">
                        {{csrf_field()}}
                        @method('DELETE')
                        {{ method_field('DELETE') }}
                        <input type="hidden"  name="id" id="order-id" value="1">
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
            $('#order-id').val(id);

            //set form action
            $('#delete-form').attr('action',"{{url('/admin/manuscript/orders')}}/"+id)
            $('#modal-dialog').modal('show');

        });

    </script>
@endsection
