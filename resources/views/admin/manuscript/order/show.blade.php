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
                            <h5>Order Detail</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form  class="form-horizontal" >
                                <div class="control-group">
                                    <label class="control-label">Order Status</label>
                                    <label class="control-label">{{ $order->order_status }}</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Order Type</label>
                                    <label class="control-label text-success">{{ $order->order_type }}</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ordered Date</label>
                                    <label class="control-label text-success">{{ $order->date_purchased }}</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Order Number</label>
                                    <label class="control-label text-success">{{ $order->id }}</label>
                                </div>

                            </form>

                            @if($order->order_type == 'Subscription')

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SUBSCRIPTION</th>
                                        <th>AMOUNT</th>
                                        <th>Frequency</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-inverse">{{\App\Subscription::findOrFail($order->subscription_id)->title}}</span><br />
                                        </td>
                                        <td>{{\App\Subscription::findOrFail($order->subscription_id)->price}}</td>
                                        <td>Monthly</td>
                                    </tr>
                                    </tbody>
                                </table>

                            @elseif($order->order_type == 'Manuscript')
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th  >Cost</th>
                                        <th >ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-center">{{\App\Manuscript::findOrFail($order->manuscript_id)->title}}</span><br />
                                        </td>

                                        <td >R{{\App\Manuscript::findOrFail($order->manuscript_id)->cost}}</td>
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
                            @endif

                            <form  class="form-horizontal" >
                                <div class="control-group">
                                    <label class="control-label">Total</label>
                                    <label class="control-label">R{{$order->order_cost}}</label>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
    <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
@endsection