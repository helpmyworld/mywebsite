@extends('layouts.frontLayout.front_design')

@section('content')

    <div class="banner10" id="home1">
        <div class="container">
            <h2 style="color: #FFF">Cancellation and Refund</h2>
        </div>
    </div>

    <!-- breadcrumbs -->
    <div class="breadcrumb_dress">
        <div class="container">
            <ul>
                <p><a href="http://helpmyworldpublishing.co.za/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a> <i>/</i></p>
                <p>Cancellation and Refund</p>
            </ul>
        </div>
    </div>

    <div class="about">
        <div class="container">
            <div class="w3ls_about_grids">
                <div class="col-md-7 w3ls_about_grid_left">


                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                    {{--<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">
                        <h3>Returns</h3>


                        <p>
                            If you are not happy about the item, you may arrange to return it to us for a refund or exchange.
                        </p>
                        <p>
                            Returns will be accepted only if the item is in the original condition.
                        </p>
                        <p>
                            Please use your order or proof of payment as reference
                        </p>

                        <p>
                            Returns must be done within 48 hours of receipt.
                        </p>
                        <p>
                            We will not accept used items or products even it it is within stipulated hours of our return policy; We reserve the
                            right to determine the condition of the product or items.
                        </p>
                        <p>
                            Once we receive and accept the returned product, your refund will be process through your original method of payment
                            within 5 - 7 working days depending on your bank in the case of electronic payments.
                        </p>

                    </div>

                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                    {{--<span class="glyphicon glyphicon-flash" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">
                        <h3>How to cancel or make a return</h3>
                        <p>Email us at helpmyworld@icloud.com or call us on 071 871 7637 to arrange for your return</p>
                        <p>Securely pack your return parcel</p>
                        <p> Depending on your choice of collection - Either take your parcel to the Post Office(Speed Service counter)
                            or the Courier will collect directly from you on an agreed date and time.</p>
                        <p> Upon arrangements returns will also be accepted at the following address:
                            416 Seder, 380 Sisulu street, Pretoria, South Africa, 0001 from 8AM - 5PM on weekdays.</p>
                    </div>
                </div>



                <div class="col-md-5 w3ls_about_grid_right">
                    {{--<div class="col-xs-2 w3ls_about_grid_left1">--}}
                    {{--<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>--}}
                    {{--</div>--}}
                    <div class="col-xs-10 w3ls_about_grid_left2">

                        <a href="{{url('terms-and-conditions')}}"><h3>Terms and Conditions</h3></a>
                        <a href="{{url('privacy-policy')}}"><h3>Privacy Policy</h3></a>
                        <a href="{{url('shipping-policy')}}"><h3>Delivery Policy</h3></a>

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
