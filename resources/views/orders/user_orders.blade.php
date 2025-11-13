@extends('layouts.frontLayout.front_design')
@section('title','My Orders — Helpmyworld Publishing')
@section('content')

<div class="site-wrapper" id="top">
    {{-- ===== Breadcrumb ===== --}}
    <section class="breadcrumb-section" style="margin-top:20px;">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">My Orders</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- ===== Orders Page (Styled like order-complete.html) ===== --}}
    <section class="order-complete inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center mb-4">
                    <h1 class="display-5 mb-3">My Orders</h1>
                    <p class="text-muted">Here’s a summary of all your placed orders.</p>
                </div>
                <div class="col-12">
                    <div class="table-responsive shadow-sm rounded">
                        <table class="table order-details-table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Ordered Products</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Grand Total</th>
                                    <th scope="col">Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->id }}</strong>
                                        </td>
                                        <td>
                                            @foreach($order->orders as $pro)
                                                <a href="{{ url('/orders/'.$order->id) }}" class="text-primary text-decoration-none">
                                                    {{ $pro->product_code }}
                                                </a><br>
                                            @endforeach
                                        </td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td><strong>R {{ number_format($order->grand_total, 2) }}</strong></td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Optional: Show empty message --}}
                    @if($orders->isEmpty())
                        <div class="text-center py-5">
                            <h4 class="text-muted">You haven’t placed any orders yet.</h4>
                            <a href="{{ url('/') }}" class="btn btn--primary mt-3">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Optional Brand Slider --}}
    <section class="section-margin">
        <h2 class="sr-only">Brand Slider</h2>
        <div class="container">
            <div class="brand-slider sb-slick-slider border-top border-bottom"
                data-slick-setting='{"autoplay": true, "autoplaySpeed": 8000, "slidesToShow": 6}'
                data-slick-responsive='[
                    {"breakpoint":992, "settings":{"slidesToShow": 4}},
                    {"breakpoint":768, "settings":{"slidesToShow": 3}},
                    {"breakpoint":575, "settings":{"slidesToShow": 2}},
                    {"breakpoint":480, "settings":{"slidesToShow": 1}}
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
