@extends('layouts.authorLayout.author_design')
@section('style')
    <style>

        .invoice-company li{
            list-style-type: none;
            display: inline;
            padding-right: 10px;
            padding-left: 10px;
            border-right: 1px solid #ddd;
        }
        .invoice-company li:last-child{
            border-right: 0px;
        }
        .mb-40{
            margin-bottom: 40px;
        }
    </style>
    @endsection

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

                    <div class="col-md-12">
                            <!-- begin invoice-company -->
                            <ul class="invoice-company">
                                <li class=" hidden-print">
                                <a href="javascript:;" onclick="window.print()" ><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
                                </li>
                                <li>
                                    Order Status: @if($order->order_status == 'Paid')<span class="text-success">{{$order->order_status}}</span>@else<span class="text-danger">{{$order->order_status}}</span>@endif
                                </li>
                            </ul>
                        </div>
                    <div class="row container mb-40">
                        <div class="col-md-6">
                            <h5 class="card-title m-b-0">Order Details</h5>
                            <!-- begin invoice-header -->
                            <div class="invoice-header">
                                <div class="">Purchase Date: {{date('d-m-Y',strtotime($order->created_at))}}</div>
                                <div class="invoice-detail">
                                    Order number:{{$order->id}}<br />
                                    Payment Method: {{$order->payment_method}}<br />
                                    Shipping Charges: {{$order->shipping_charges}}<br />
                                </div>
                            </div>
                            <!-- end invoice-header -->
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title m-b-0">Customer Details</h5>
                            <!-- begin invoice-header -->
                            <div class="invoice-header">
                                <div class="invoice-date">
                                    {{-- <small>Invoice / July period</small>--}}
                                    <div class="invoice-detail">
                                        Customer Name:{{\App\User::findOrFail($order->user_id)->name}}<br />
                                        Customer Email: {{\App\User::findOrFail($order->user_id)->email}}<br />
                                        Customer Email: {{\App\User::findOrFail($order->user_id)->mobile}}<br />
                                    </div>
                                </div>
                            </div>
                            <br>

                            <h5 class="card-title m-b-0">Customer Shipping Address</h5>
                            <div class="invoice-header">
                                <div class="invoice-date">
                                    <div class="invoice-detail">
                                        Customer Name:{{\App\User::findOrFail($order->user_id)->address}}<br />
            
                                    </div>
                                </div>
                            </div>

                            <!-- end invoice-header -->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="invoice-content">
                            <!-- begin table-responsive -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Cost</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->orders as $row)
                                        @if(\App\Product::where('user_id',auth()->id())->where("id",$row->product_id)->first())
                                        <tr>
                                            <td>
                                                <span class="text-center">{{\App\Product::findOrFail($row->product_id)->product_name}}</span><br />
                                            </td>

                                            <td class="text-center">R{{\App\Product::findOrFail($row->product_id)->price}}</td>
                                            <td class="text-center">{{$row->product_qty}}</td>
                                            <td> 
                                                @if($row->product_type == "ebook")
                                                  <a target="_blank" href="{{ url('author/generate_ebook_link/'.$row->id)}}" class="btn btn-primary btn-mini">Send Ebook Link</a>

                                                 @endif
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                        <!-- end invoice-content -->
                        <!-- begin invoice-price -->
                        <div class="invoice-price mb-40">
                            <div class="invoice-price-right">
                                <strong>TOTAL</strong> <span class="f-w-600">R{{$order->grand_total}}</span>
                            </div>
                        </div>
                        <!-- end invoice-price -->
                    </div>

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
