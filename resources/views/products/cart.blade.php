@extends('layouts.frontLayout.front_design')
<?php use App\Product; ?>

@section('content')
<div class="site-wrapper" id="top">
    {{-- Breadcrumb --}}
    <section class="breadcrumb-section" style="margin-top:20px;">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- Flash messages (unchanged) --}}
    <div class="container" style="margin-top:10px;">
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
    </div>

    {{-- Cart Page --}}
    <main class="cart-page-main-block inner-page-sec-padding-bottom">
        <div class="cart_area cart-area-padding">
            <div class="container">
                <div class="page-section-title">
                    <h1>Shopping Cart</h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{-- Cart Table --}}
                        <div class="cart-table table-responsive mb--40">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="pro-remove">Remove</th>
                                        <th class="pro-thumbnail">Product</th>
                                        <th class="pro-price">Price</th>
                                        <th class="pro-quantity">Quantity</th>
                                   
                                        <th class="pro-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $total_amount = 0; @endphp
                                @forelse($userCart as $cart)
                                    @php
                                        $lineTotal = ($cart->price * $cart->quantity);
                                        $total_amount += $lineTotal;
                                    @endphp
                                    <tr>
                                        {{-- Remove --}}
                                        <td class="pro-remove">
                                            <a class="cart_quantity_delete" href="{{ url('/cart/delete-product/'.$cart->id) }}" title="Remove">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>

                                        {{-- Image --}}
                                        <td class="pro-thumbnail" style="min-width:110px;">
                                            <a href="#">
                                                @php $img = $cart->image ? asset('/images/backend_images/product/small/'.$cart->image) : asset('images/no-image.png'); @endphp
                                                <img src="{{ $img }}" alt="{{ $cart->product_name }}" style="width:100px;">

                                                <a href="#">{{ $cart->product_name }}</a>
                                            </a>
                                        </td>

                                        {{-- Title --}}
                                       

                                        {{-- Price --}}
                                        <td class="pro-price">
                                            <span>R {{ number_format($cart->price,2) }}</span>
                                        </td>

                                        {{-- Quantity (kept your +1 / -1 links) --}}

                                        <<td class="pro-quantity" colspan="2">
    <div class="d-flex align-items-center justify-content-between" style="gap:20px; width:100%;">
        {{-- Quantity block --}}
        <div class="count-input-block d-inline-flex align-items-center" style="gap:8px;">
            <a class="cart_quantity_down btn btn-sm btn-outline-secondary"
               href="{{ url('/cart/update-quantity/'.$cart->id.'/-1') }}"
               @if($cart->quantity<=1) aria-disabled="true" onclick="return false;" @endif>-</a>

            <input type="text"
                   class="form-control text-center"
                   value="{{ $cart->quantity }}"
                   readonly
                   style="max-width:60px;">

            <a class="cart_quantity_up btn btn-sm btn-outline-secondary"
               href="{{ url('/cart/update-quantity/'.$cart->id.'/1') }}">+</a>
        </div>

        {{-- Inline total --}}
        <div class="line-total text-right" style="min-width:100px;">
            <strong>R {{ number_format($cart->price * $cart->quantity, 2) }}</strong>
        </div>
    </div>
</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Your cart is empty.</td>
                                    </tr>
                                @endforelse

                                {{-- Coupon Row --}}
                                <tr>
                                    <td colspan="6" class="actions">
                                        <div class="d-flex justify-content-between flex-wrap" style="gap:10px;">
                                            <form action="{{ url('cart/apply-coupon') }}" method="post" class="d-flex align-items-center" style="gap:10px;">
                                                @csrf
                                                <label for="coupon_code" class="mb-0">Coupon:</label>
                                                <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Coupon code" style="max-width:220px;">
                                                <button type="submit" class="btn btn-outlined">Apply coupon</button>
                                            </form>

                                            <a class="btn btn-outlined" href="{{ url()->current() }}">Update</a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div> {{-- /.cart-table --}}
                    </div>
                </div>

                {{-- Summary + Checkout --}}
                <div class="row">
                    <div class="col-lg-6 col-12 mb--30">
                        {{-- (Optional) recommendations area could go here --}}
                    </div>

                    <div class="col-lg-6 col-12 d-flex">
                        <div class="cart-summary w-100">
                            <div class="cart-summary-wrap">
                                <h4><span>Cart Summary</span></h4>

                                @if(!empty(Session::get('CouponAmount')))
                                    <p>Sub Total
                                        <span class="text-primary">R {{ number_format($total_amount,2) }}</span>
                                    </p>
                                    <p>Coupon Discount
                                        <span class="text-primary">R {{ number_format(Session::get('CouponAmount'),2) }}</span>
                                    </p>
                                    @php
                                        $total_amount = $total_amount - Session::get('CouponAmount');
                                        $getCurrencyRates = Product::getCurrencyRates($total_amount);
                                    @endphp
                                    <h2>
                                        Grand Total
                                        <span class="text-primary btn-secondary"
                                              data-toggle="tooltip"
                                              data-html="true"
                                              title="USD {{ $getCurrencyRates['USD_Rate'] }}<br>GBP {{ $getCurrencyRates['GBP_Rate'] }}<br>EUR {{ $getCurrencyRates['EUR_Rate'] }}">
                                            R {{ number_format($total_amount,2) }}
                                        </span>
                                    </h2>
                                @else
                                    @php $getCurrencyRates = Product::getCurrencyRates($total_amount); @endphp
                                    <h2>
                                        Grand Total
                                        <span class="text-primary btn-secondary"
                                              data-toggle="tooltip"
                                              data-html="true"
                                              title="USD {{ $getCurrencyRates['USD_Rate'] }}<br>GBP {{ $getCurrencyRates['GBP_Rate'] }}<br>EUR {{ $getCurrencyRates['EUR_Rate'] }}">
                                            R {{ number_format($total_amount,2) }}
                                        </span>
                                    </h2>
                                @endif
                            </div>

                            <div class="cart-summary-button d-flex justify-content-between flex-wrap" style="gap:10px;">
                                <a href="{{ url('/cart') }}" class="update-btn c-btn btn-outlined">Update Cart</a>

                                @if(!empty($is_ebook_present))
                                    <a href="{{ url('/order-review') }}" class="checkout-btn c-btn btn--primary">Checkout</a>
                                @else
                                    <a href="{{ url('/checkout') }}" class="checkout-btn c-btn btn--primary">Checkout</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /.container --}}
        </div>
    </main>

    {{-- Brand slider (kept from theme, optional) --}}
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
