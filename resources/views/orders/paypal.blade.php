
@extends('layouts.frontLayout.front_design')
@section('content')
    <?php use App\Order; ?>
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Thanks</li>
                </ol>
            </div>
        </div>
    </section>

    <section id="do_action">
        <div class="container">
            <div class="heading" align="center">
                <h3>YOUR ORDER HAS BEEN PLACED</h3>
                <p>Your order number is {{ Session::get('order_id') }} and total payable about is R {{ Session::get('grand_total') }}</p>
                <p>Please make payment by clicking on below Payment Button</p>
                <?php
                $orderDetails = Order::getOrderDetails(Session::get('order_id'));
                $orderDetails = json_decode(json_encode($orderDetails));
                /*echo "<pre>"; print_r($orderDetails); die;*/
                $nameArr = explode(' ',$orderDetails->name);
                $getCountryCode = Order::getCountryCode($orderDetails->country);
                ?>
                <form id="payfast-form" action="https://www.payfast.co.za/eng/process" method="POST">
                    <input type="hidden" name="merchant_id" value="13013445">
                    <input type="hidden" name="merchant_key" value="kz6v5zebgr2xh">
                       <input type="hidden" name="return_url" value="http://berylcoin.com/thanks">
                    <input type="hidden" name="cancel_url" value="http://berylcoin.com/cancel">
                    <input type="hidden" name="notify_url" value="{{ url('itn') }}">
                      <input type="hidden" name="name_first" value="{{ $nameArr[0] }}">
                    <input type="hidden" name="name_last" value="{{ $nameArr[1] }}">
                    <input type="hidden" name="email_address" value="{{ $orderDetails->user_email }}">
                    <input type="hidden" name="m_payment_id" value="{{ Session::get('order_id') }}">
                    <input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
                    <input type="hidden" name="item_name" value="Order {{ Session::get('order_id') }}">
                    <input type="hidden" id="signature" name="signature">
                </form>
                <input type="image" id="pay-now"
                       src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Pay Now">
                <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif"
                     width="1" height="1">
            </div>
        </div>
    </section>

@endsection

<?php
Session::forget('grand_total');
Session::forget('order_id');
?>


