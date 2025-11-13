@extends('layouts.authorLayout.author_design')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Order</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order</li>
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
                        <h5 class="card-title m-b-0">My Orders</h5>
                    </div>

                    @if($order->order_type == 'Subscription')
                        <div class="col-md-12">
                            <!-- begin invoice-company -->
                            <div class="invoice-company text-inverse f-w-600">
                    <span class="pull-right hidden-print">
                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
                    </span>
                                Order Status: <span class="text-success">{{$order->paid ? 'Paid' : 'Unpaid'}}</span> Order Type: <span class="text-success">{{$order->order_type}}</span>
                            </div>
                            <!-- end invoice-company -->
                            <!-- begin invoice-header -->
                            <div class="invoice-header">

                                <div class="invoice-date">
                                    {{-- <small>Invoice / July period</small>--}}
                                    <div class="date text-inverse m-t-5">Purchase Date: {{date('d-m-Y',strtotime($order->date_purchased))}}</div>
                                    <div class="invoice-detail">
                                        Order number:{{$order->id}}<br />
                                        {{$order->payment_method}}<br />
                                    </div>
                                </div>
                            </div>
                            <!-- end invoice-header -->
                            <!-- begin invoice-content -->
                            <div class="invoice-content">
                                <!-- begin table-responsive -->
                                <div class="table-responsive">
                                    <table class="table table-invoice">
                                        <thead>
                                        <tr>
                                            <th>SUBSCRIPTION</th>
                                            <th class="text-center" width="10%">AMOUNT</th>
                                            <th class="text-center" width="10%">FREQUENCY</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <span class="text-inverse">{{\App\Subscription::findOrFail($order->subscription_id)->title}}</span><br />
                                            </td>
                                            <td class="text-center">{{\App\Subscription::findOrFail($order->subscription_id)->price}}</td>
                                            <td class="text-center">Monthly</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                                <!-- begin invoice-price -->
                                <div class="invoice-price">
                                    <div class="invoice-price-right">
                                        <small>TOTAL</small> <span class="f-w-600">R{{$order->order_cost}}</span>
                                    </div>
                                </div>
                                <!-- end invoice-price -->
                            </div>
                            <!-- end invoice-content -->
                        </div>
                    @elseif($order->order_type == 'Manuscript')
                        <div class="col-md-12">
                            <!-- begin invoice-company -->
                            <div class="invoice-company text-inverse f-w-600">
                    <span class="pull-right hidden-print">
                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
                    </span>
                                Order Status: <span class="text-success">{!! $order->paid ? 'Paid' : '<span class="text-danger">Unpaid</span>' !!}</span> <br>Order Type: <span class="text-success">{{$order->order_type}}</span>
                            </div>
                            <!-- end invoice-company -->
                            <!-- begin invoice-header -->
                            <div class="invoice-header">
                                <div class="invoice-date">
                                    {{-- <small>Invoice / July period</small>--}}
                                    <div class="date text-inverse m-t-5">Purchase Date: {{date('d-m-Y',strtotime($order->date_purchased))}}</div>
                                    <div class="invoice-detail">
                                        Order number:{{$order->id}}<br />
                                        {{$order->payment_method}}<br />
                                    </div>
                                </div>
                            </div>
                            <!-- end invoice-header -->
                            <!-- begin invoice-content -->
                            <div class="invoice-content">
                                <!-- begin table-responsive -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th  >Cost</th>
                                            <th class="text-center" >ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <span class="text-center">{{\App\Manuscript::findOrFail($order->manuscript_id)->title}}</span><br />
                                            </td>

                                            <td class="text-center">R{{\App\Manuscript::findOrFail($order->manuscript_id)->cost}}</td>
                                            <td>

                                                @if($order->paid==1)
                                                    <h5></h5>
                                                @else
                                                    <h5 class="text-danger">Product not paid</h5>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                            <!-- end invoice-content -->
                            <!-- begin invoice-price -->
                            <div class="invoice-price">
                                <div class="invoice-price-right">
                                    <small>TOTAL</small> <span class="f-w-600">R{{$order->order_cost}}</span>
                                </div>
                            </div>
                            <!-- end invoice-price -->
                        </div>
                    @endif

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

@endsection
