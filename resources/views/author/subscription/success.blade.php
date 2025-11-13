@extends('layouts.authorLayout.author_design')


@section('content')

    <!-- begin #content -->
    <div  class="container-fluid">
    @include('layouts.response')
    <!-- begin breadcrumb -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-2 -->

            <!-- end col-2 -->
            <!-- begin col-10 -->
            <div class="col-md-6">
                <div class="panel panel-success" data-sortable-id="ui-widget-1" style="box-shadow: 2px 5px 2px #888888">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                        </div>
                        <h4 class="panel-title">Your Current Subscription Plan</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">

                            <tr>
                                <th>Plan Name:</th>
                                <td>{{auth()->user()->sub()->subscription_name}}</td>
                            </tr>
                            <tr>
                                <th>Cost:</th>
                                <td>{{\App\ManuscriptOrder::findOrFail(auth()->user()->sub()->order_id)->order_cost}}</td>
                            </tr>
                            <tr>
                                <th>Started:</th>
                                <td>{{auth()->user()->sub()->start_date}}</td>
                            </tr>
                            <tr>
                                <th>Next Billing Date:</th>
                                <td>{{auth()->user()->sub()->getNextSubscriptionBillingDate()}}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>{{auth()->user()->sub()->status}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="note note-success note-with-right-icon" style="box-shadow: 2px 5px 2px #888888">
                    <div class="note-icon"><i class="fa fa-check-circle"></i></div>
                    <div class="note-content text-right">
                        <h4><b>Subscription Active.</b></h4>
                        <p> Your Subscription is now active, You can cancel your subscription at any time from the Subscription Dashboard.  </p>
                    </div>
                </div>
            </div>


            <!-- end col-10 -->
        </div>
        <hr>
        <!-- end row -->
    </div>
    <!-- end #content -->



@endsection
