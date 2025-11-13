@extends('layouts.authorLayout.author_design')

@section('content')

    <!-- begin #content -->
    <div id="content" class="container-fluid">
    @include('layouts.response')
    <!-- begin breadcrumb -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-2 -->

            <!-- end col-2 -->
            <!-- begin col-10 -->
                    <div class="col-md-6">
                <div class="panel panel-warning" data-sortable-id="ui-widget-1" style="box-shadow: 2px 5px 2px #888888">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="#" class="btn btn-xs btn-icon btn-circle btn-default"
                               data-click="panel-expand">
                                <i class="fa fa-expand"></i>
                            </a>
                            ...
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
                                <th>Ends:</th>
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
                        <div class="note note-warning note-with-right-icon" style="box-shadow: 2px 5px 2px #888888">
                            <div class="note-icon"><i class="fa fa-spinner fa-spin"></i></div>
                            <div class="note-content text-right">
                                <h4><b>Subscription Canceled. We are sad to see you go</b></h4>
                                <p> Your Subscription is canceled, Your membership will be active until {{auth()->user()->subscription()->getNextSubscriptionBillingDate()}} if you want to restart your subscription you will need to re-apply  </p>
                            </div>
                        </div>
                    </div>


            <!-- end col-10 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->



@endsection
