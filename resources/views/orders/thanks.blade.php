{{-- resources/views/orders/thanks.blade.php --}}
@extends('layouts.frontLayout.front_design')

@section('title','Order Complete — Helpmyworld Publishing')

@section('content')
@php
    $orderId     = Session::get('order_id');
    $grandTotal  = Session::get('grand_total');
    $displayDate = date('F j, Y');
    // "thanks" is only hit on COD/EFT in your controller
    $paymentMethod = 'Cash on Delivery / EFT';
@endphp

<div class="site-wrapper" id="top">
    {{-- Breadcrumb --}}
    <section class="breadcrumb-section" style="margin-top:20px;">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Order Complete</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- Order Complete --}}
    <section class="order-complete inner-page-sec-padding-bottom">
        <div class="container">
            {{-- Flash messages (unchanged behavior) --}}
            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
            @if(Session::has('flash_message_error'))
                <div class="alert alert-error alert-block" style="background-color:#f4d2d2">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="order-complete-message text-center">
                        <h1>Thank you!</h1>
                        <p>Your order has been received.</p>
                    </div>

                    <ul class="order-details-list">
                        <li>Order Number: <strong>{{ $orderId ?? '—' }}</strong></li>
                        <li>Date: <strong>{{ $displayDate }}</strong></li>
                        <li>Total: <strong>R {{ number_format((float)$grandTotal, 2) }}</strong></li>
                        <li>Payment Method: <strong>{{ $paymentMethod }}</strong></li>
                    </ul>

                    <p>We’ve emailed your order confirmation. If you chose EFT, please follow the payment instructions in the email.</p>

                    {{-- Optional: quick actions --}}
                    <div class="mt-4 d-flex" style="gap:10px;">
                        <a href="{{ url('/') }}" class="btn btn--primary">Continue Shopping</a>
                        @auth
                            <a href="{{ url('/orders') }}" class="btn btn-outline-secondary">View My Orders</a>
                        @endauth
                    </div>

                    {{-- If in future you pass $orderDetails to this view, you can show a detailed table. --}}
                    @isset($orderDetails)
                        <h3 class="order-table-title mt-5">Order Details</h3>
                        <div class="table-responsive">
                            <table class="table order-details-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderDetails->orders as $row)
                                        <tr>
                                            <td>
                                                {{ $row->product_name }}
                                                <strong>× {{ (int)$row->product_qty }}</strong>
                                            </td>
                                            <td class="text-right">
                                                <span>R {{ number_format($row->product_price * $row->product_qty, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td class="text-right">
                                            R {{ number_format(collect($orderDetails->orders)->sum(fn($r)=>$r->product_price*$r->product_qty), 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method:</th>
                                        <td class="text-right">{{ $orderDetails->payment_method }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td class="text-right">
                                            R {{ number_format($orderDetails->grand_total, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </section>

    {{-- (Optional) brand strip from your theme; remove if your layout already includes it --}}
    <section class="section-margin">
        <h2 class="sr-only">Brand Slider</h2>
        <div class="container">
            <div class="brand-slider sb-slick-slider border-top border-bottom"
                 data-slick-setting='{"autoplay": true, "autoplaySpeed": 8000, "slidesToShow": 6}'
                 data-slick-responsive='[
                    {"breakpoint":992, "settings":{"slidesToShow": 4}},
                    {"breakpoint":768, "settings":{"slidesToShow": 3}},
                    {"breakpoint":575, "settings":{"slidesToShow": 3}},
                    {"breakpoint":480, "settings":{"slidesToShow": 2}},
                    {"breakpoint":320, "settings":{"slidesToShow": 1}}
                 ]'>
                <div class="single-slide"><img src="{{ asset('image/others/brand-1.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-2.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-3.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-4.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-5.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-6.jpg') }}" alt=""></div>
            </div>
        </div>
    </section>
</div>
@endsection
