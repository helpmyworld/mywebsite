@extends('layouts.adminLayout.admin_design')

@section('content')

    <!-- begin #content -->
    <div id="content">
    @include('layouts.response')
    <!-- begin breadcrumb -->
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Benefit</a> <a href="#" class="current">View</a> </div>
            <h1>Manuscript</h1>
        </div>

        <!-- end breadcrumb -->


        <!-- begin row -->
        <div class="container-fluid"><hr>
        <!-- end #content -->
            <div class="row-fluid">
                <div class="span12">
                    <h1 class="page-header"><a href="{{route('admin.subscription.benefits.create')}}" class="btn btn-dark">Add Subscription Benefit <i class="fa fa-plus"></i></a> </h1>
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Users</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>

                                <tr>
                                    <th width="1%">ID</th>
                                    <th class="text-nowrap">Name</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>

                                </thead>
                                <tbody>
                                @foreach($benefits as $row)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="f-s-600 text-inverse">{{$row->id}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>
                                            <div class="span4">
                                                <a href="{{route('admin.subscription.benefits.edit',['id' => $row->id])}}" class="btn btn-success">
                                                    Edit
                                                </a>
                                            </div>
                                            <div class="span8">
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
    </div>


    <!--====================================== #modal-dialog ========================================-->
    <div class="modal fade" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Benefit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to delete this Benefit
                    </p>
                    <form id="delete-form" action="" method="post">
                        {{csrf_field()}}
                        @method('DELETE')
                        {{ method_field('DELETE') }}
                        <input type="hidden"  name="id" id="benefit-id" value="1">
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
                $('#benefit-id').val(id);

                //set form action
                $('#delete-form').attr('action',"{{url('/admin/subscription/benefits')}}/"+id)
                $('#modal-dialog').modal('show');

            });



        </script>

        @endsection
