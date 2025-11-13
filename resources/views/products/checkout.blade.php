@extends('layouts.frontLayout.front_design')
@section('content')
  <style> .cart_menu {
    background: #50bfb6;
    color: #fff;
    font-size: 16px;
    font-family: 'Roboto', sans-serif;
    font-weight: normal;
    height: 51px;
}

.table {
    width: 100%;
    
}

table {
    max-width: 100%;
    background-color: transparent;
}
table {
    border-collapse: collapse;
    border-spacing: 0;
}

.table-condensed{
    
    border:1px solid #E6E4DF;
    margin-bottom: 20px;
}
</style>
<section id="form" style="margin-top:20px;"><!--form-->
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="#">Home</a></li>
			  <li class="active">Check Out</li>
			</ol>
		</div>
		@if(Session::has('flash_message_error'))
            <div class="alert alert-error alert-block" style="background-color:#f4d2d2">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{!! session('flash_message_error') !!}</strong>
            </div>
		@endif
		<form action="{{ url('/checkout') }}" method="post">{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Bill To</h2>
							<div class="form-group">
								<input name="billing_name" id="billing_name" @if(!empty($userDetails->name)) value="{{ $userDetails->name }}" @endif type="text" placeholder="Billing Name" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_address" id="billing_address" @if(!empty($userDetails->address)) value="{{ $userDetails->address }}" @endif type="text" placeholder="Billing Address" class="form-control" />
							</div>
							<div class="form-group">	
								<input name="billing_city" id="billing_city" @if(!empty($userDetails->city)) value="{{ $userDetails->city }}" @endif type="text" placeholder="Billing City" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_state" id="billing_state" @if(!empty($userDetails->state)) value="{{ $userDetails->state }}" @endif type="text" placeholder="Billing State" class="form-control" />
							</div>
							<div class="form-group">
								<select id="billing_country" name="billing_country" class="form-control">
									<option value="">Select Area/City</option>
									@foreach($countries as $country)
										<option value="{{ $country->country_name }}" @if(!empty($userDetails->country) && $country->country_name == $userDetails->country) selected @endif>{{ $country->country_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->name)) value="{{ $userDetails->pincode }}" @endif type="text" placeholder="Billing Pincode" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile)) value="{{ $userDetails->mobile }}" @endif type="text" placeholder="Billing Mobile" class="form-control" />
							</div>
							<div class="form-check">
							    <input type="checkbox" type="radio" class="form-check-input" id="copyAddress" >
							    <label class="form-check-label" for="copyAddress">Shipping Address same as Billing Address</label>
							</div>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Ship To</h2>
							<div class="form-group">
								<input name="shipping_name" id="shipping_name" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->name }}" @endif type="text" placeholder="Shipping Name" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_address" id="shipping_address" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif type="text" placeholder="Shipping Address" class="form-control" />
							</div>
							<div class="form-group">	
								<input name="shipping_city" id="shipping_city" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif type="text" placeholder="Shipping City" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_state" id="shipping_state" @if(!empty($shippingDetails->state)) value="{{ $shippingDetails->state }}" @endif type="text" placeholder="Shipping State" class="form-control" />
							</div>
							<div class="form-group">
								<select id="shipping_country" name="shipping_country" class="form-control">
									<option value="">Select Area/City</option>
									@foreach($countries as $country)
										<option value="{{ $country->country_name }}" @if(!empty($shippingDetails->country) && $country->country_name == $shippingDetails->country) selected @endif>{{ $country->country_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input name="shipping_pincode" id="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{ $shippingDetails->pincode }}" @endif type="text" placeholder="Shipping Pincode" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_mobile" id="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif type="text" placeholder="Shipping Mobile" class="form-control" />
							</div>
							
							
							
							
			
			
							{{--<button type="submit" class="btn btn-default">Check Out</button>--}}
					</div><!--/sign up form-->
				</div>
			</div>
	
		
		<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
						</tr>
					</thead>
					<tbody>
						<?php $total_amount = 0; ?>
						@foreach($userCart as $cart)
						<tr>
							<td class="cart_product">
								<a href=""><img style="width:130px;" src="{{ asset('/images/backend_images/product/small/'.$cart->image) }}" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $cart->product_name }}</a></h4>
									{{--<p>Product Code: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $cart->product_code }}</p>--}}
							</td>
							<td class="cart_price">
								<p>R {{ $cart->price }}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									{{ $cart->quantity }}
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">R {{ $cart->price*$cart->quantity }}</p>
							</td>
						</tr>
						<?php $total_amount = $total_amount + ($cart->price*$cart->quantity); ?>
						@endforeach
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result" style="border:none">
									<tr>
										<td>Cart Sub Total</td>
										<td>R {{ $total_amount }}</td>
									</tr>
									<tr class="shipping-cost">
    <td>Shipping Cost (+)</td>
    <td data-shipping-cost="{{ $shippingCharges }}">R {{ $shippingCharges }}</td>
</tr>
									<tr class="shipping-cost">
										<td>Discount Amount (-)</td>
										<td>
											@if(!empty(Session::get('CouponAmount')))
												R {{ Session::get('CouponAmount') }}
											@else
												R 0
											@endif
										</td>	
									</tr>
									<tr>
										<td>Grand Total</td>
										<?php
										$grand_total = $total_amount + $shippingCharges - Session::get('CouponAmount');
										$getCurrencyRates = App\Product::getCurrencyRates($total_amount); ?>
										<td>
										    <span class="btn-secondary" id="gradtotal" data-grand-total="{{ $grand_total }}" data-toggle="tooltip" data-html="true" title="
    USD {{ $getCurrencyRates['USD_Rate'] }}<br>
    GBP {{ $getCurrencyRates['GBP_Rate'] }}<br>
    EUR {{ $getCurrencyRates['EUR_Rate'] }}">
    R {{ $grand_total }}
</span>
</td>

									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
				<input type="hidden" name="grand_total" id="ckamount" value="{{ $grand_total }}">
				<div class="payment-options" style="margin-top:10px">
					<span>
						<label><strong>Select Payment Method:</strong></label>
					</span>
          <span>
						<label><input type="radio" name="payment_method" id="COD" value="COD"> <strong>COD/EFT</strong></label>
					</span>
					<span>
						<label><input type="radio" name="payment_method" id="Paypal" value="Paypal"> <strong>Payfast/Visa/MasterCard</strong></label>
					</span>
					<span style="float:right;">
						<button type="submit" class="btn btn-success" onclick="return selectPaymentMethod();">Check Out</button>
					</span>
				</div>
			</form>
	</div>
</section><!--/form-->
<br><br> <br>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    
  $(document).ready(function() {
    $('#billing_country').on('change', function() {
        var country = $(this).val();
        if (country) {
            $.ajax({
                url: '/getrate/' + country, // Laravel route to get the shipping rate
                type: 'GET',
                success: function(response) {
                    // Update shipping cost
                    $('.shipping-cost td:last-child').text('R ' + response);

                    // Update grand total by recalculating
                    var oldShipping = parseFloat($('.shipping-cost td:last-child').data('shipping-cost'));
                    var grandTotal = parseFloat($('#gradtotal').data('grand-total'));
                    var newGrandTotal = grandTotal - oldShipping + parseFloat(response);

                    // Update grand total on the page
                    $('#gradtotal').text('R ' + newGrandTotal.toFixed(2));
                    $('#ckamount').val(newGrandTotal.toFixed(2));
                    
                    // Update the data attributes for the new values
                    $('.shipping-cost td:last-child').data('shipping-cost', response);
                    $('#gradtotal').data('grand-total', newGrandTotal);
                },
                error: function() {
                    alert('Error fetching shipping rate');
                }
            });
        }
    });

    // === NEW: Billing -> Shipping copy helper (keeps behavior identical to your original) ===
    function copyBillingToShipping(){
        $('#shipping_name').val($('#billing_name').val());
        $('#shipping_address').val($('#billing_address').val());
        $('#shipping_city').val($('#billing_city').val());
        $('#shipping_state').val($('#billing_state').val());
        $('#shipping_country').val($('#billing_country').val());
        $('#shipping_pincode').val($('#billing_pincode').val());
        $('#shipping_mobile').val($('#billing_mobile').val());
    }

    // When the checkbox is toggled, copy once (if checked)
    $('#copyAddress').on('change', function(){
        if(this.checked){
            copyBillingToShipping();
        }
    });

    // While checked, keep shipping fields synced as the user edits billing fields
    $('#billing_name, #billing_address, #billing_city, #billing_state, #billing_country, #billing_pincode, #billing_mobile')
        .on('input change', function(){
            if($('#copyAddress').is(':checked')){
                copyBillingToShipping();
            }
        });
  });
  
</script>



@endsection
