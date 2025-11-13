@extends('layouts.frontLayout.front_design')

@section('content')

    <div id="contact-page" class="container">
        <div class="bg">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="title text-center">Shipping-Policy</h2>

                </div>
            </div>
            <div class="w3ls_about_grids">
                <div class="col-md-7 w3ls_about_grid_left">


                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                        {{--<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">
                        <h3>Delivery Options</h3>
                        <p>We have the following delivery methods for us to work well together</p>

                        <p>If you register as a subscriber, we do not make your personally identifiable information
                            available to anyone unless required by law to do so.</p>
                    </div>
                    <div class="clearfix"> </div>
                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                        {{--<span class="glyphicon glyphicon-flash" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">
                        <h3>Collection</h3>
                        <p>You can also collect your parcel from our office in Pretoria;  (416 Seder, 380 Sisulu street, Pretoria, South Africa, 0001) from 8AM - 5PM on weekdays. Weekends collections are done on arrangements.</p>
                        <br>
                        <div class="desc"></div>
                        <h3>Post delivery</h3>
                        <p> We use the SA Post Office to deliver to any valid South African postal address. We will send you a tracking number by email when we
                            dispatch your order and you should receive a post office collection slip about 7-10 days later.
                            You can then collect the parcel from your local post office counter. Postal delivery is R105 on all eligible orders.</p>
                        <br>
                        <div class="desc"></div>
                        <h3>Courier</h3>
                        <p>
                            This is a door-to-door service. You must supply us with your physical address and someone will need to be available at the address to
                            receive the delivery. Deliveries are made during business hours from Monday to Friday. In main centres, this will reach you within 5-7
                            business days of dispatch. Main centres include properties within a 50km radius of the major cities in South Africa. If you are not in a
                            main centre, it may take a few days longer. We do not deliver by courier to plots, farms, mines, military bases, major chain stores, power
                            stations, game reserves and lodges, airports or harbours, and should your delivery address fall into one of these categories you will be
                            liable for the extra costs incurred in delivering or returning the parcel. We offer delivery of parcels up to 10kg. Delivery on orders over
                            10kg is calculated based on mass, value, and number of items in the order.


                        </p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="col-md-5 w3ls_about_grid_right">
                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                        {{--<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">

                        <div class="desc"></div>
                        <a href="{{url('terms-and-conditions')}}"><h3>Terms and Conditions</h3></a>
                        <a href="{{url('privacy-policy')}}"><h3>Privacy Policy</h3></a>
                        {{--<a href="{{url('shipping-policy')}}"><h4>Delivery Policy</h4></a>--}}
                        <a href="{{url('cancellation-refund')}}"><h3>Cancellation and Refund</h3></a>
                    </div>
                    <div class="clearfix"> </div>
                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                        {{--<span class="glyphicon glyphicon-flash" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-10 w3ls_about_grid_left2">--}}

                        {{--<div class="desc"></div>--}}
                        {{--<a href="{{url('terms-and-conditions')}}"><h4>Terms and Conditions</h4></a>--}}
                        {{--<a href="{{url('privacy-policy')}}"><h4>Privacy Policy</h4></a>--}}
                        {{--<a href="{{url('shipping-policy')}}"><h4>Delivery Policy</h4></a>--}}
                        {{--<a href="{{url('cancellation-refund')}}"><h4>Cancellation and Refund</h4></a>--}}
                    {{--</div>--}}
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>


@endsection
