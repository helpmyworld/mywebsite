@extends('layouts.adminLayout.admin_design')

@section('content')

    <!-- begin #content -->
    <div id="content">
        <!-- begin breadcrumb -->
    @include('layouts.response')

    <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Create Host Function <small>...</small></h1>
        <!-- end page-header -->

        <div class="container-fluid">
            <!-- begin row -->
            <div class="row-fluid">
            <!-- begin col-6 -->
            <div class="span12">
                <!-- begin panel -->
                <div class="widget-box" data-sortable-id="form-plugins-1">
                    <!-- begin panel-heading -->
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Add Function</h5>
                    </div>
                    <!-- end panel-heading -->
                    <!-- begin panel-body -->
                    <div class="widget-content nopadding">
                        <form class="form-horizontal"  method="post" action="{{route('admin.capacities.store')}}" >
                            {{csrf_field()}}

                            <div class="control-group">
                                <label class="control-label" for="inputEmail">Hosting Function Title</label>
                                <div class="controls">
                                    <input type="text" name="name" placeholder="Enter name" class="form-control"  value="" required>
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

@endsection
