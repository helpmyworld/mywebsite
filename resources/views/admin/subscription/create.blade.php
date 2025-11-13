@extends('layouts.adminLayout.admin_design')

@section('content')

    <!-- begin #content -->
    <div id="content">
        <!-- begin breadcrumb -->
    @include('layouts.response')

    <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Create Subscription <small>...</small></h1>
        <!-- end page-header -->

        <div class="container-fluid">
            <!-- begin row -->
            <div class="row-fluid">
                <!-- begin col-6 -->
                <div class="span12">
                    <!-- begin panel -->
                    <div class="widget-box">
                        <!-- begin panel-heading -->
                        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Add Subscription</h5>
                        </div>
                        <!-- end panel-heading -->
                        <!-- begin panel-body -->
                        <div class="widget-content nopadding">
                            <form class="form-horizontal"  method="post" action="{{route('admin.subscriptions.store')}}" >
                                {{csrf_field()}}

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Subscription Title</label>
                                    <div class="controls">
                                        <input type="text" name="title" placeholder="Enter title" class="form-control"  value="" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Subscription Price</label>
                                    <div class="controls">
                                        <input type="text" name="price" placeholder="200.00" class="form-control"  value="" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Subscription Benefits</label>
                                    <div class="controls">
                                        <select class="select2-multi"  id="benefit" name="benefits[]"   multiple >
                                            <option>Select benefits</option>
                                            @foreach($benefits as $row)
                                                <option value="{{$row->id}}"  >{{$row->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <button class="btn" type="submit">Add</button>
                            </form>
                        </div>
                        <!-- end panel-body -->
                    </div>
                    <!-- end panel -->


                </div>
                <!-- end col-6 -->

            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- end #content -->
    <script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>

    <script src="{{ asset('/js/backend_js/select2.min.js') }}"></script>

    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>
@endsection
