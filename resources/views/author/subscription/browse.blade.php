@extends('layouts.authorLayout.author_design')

@section('content')

    <!-- begin #content -->
    <div id="container-fluid">
    @include('layouts.response')
    <!-- begin breadcrumb -->

        <!-- begin row -->
        <div class="container">
      <div class="row">
          <div class="col-xs-12" align="center">
             <h2>Choose your desired subscription plan</h2>
             <br>
             <h3 style="color:red; text-align: center">*You will be billed monthly on the same day of sign up every month* | Make sure that you sign up for subscription on the day
             that you will like your debit to go through</h3>
             
             <h3>If you are unsure about this step. contact Rorisang Maimane @ rorisang@helpmyworld.co.za or 071 871 7637/ 012 309 4217</h3>
          </div>
      </div>

      </div><!-- end row -->
        <section class="pricing py-5">
            <div class="container">
                <div class="row">
                    <!-- Free Tier -->
                    @if(isset(request()->subscription) && request()->subscription == 'premium')
                        @php
                        $premium = \App\Subscription::where('title','Indie.Africa')->first();
                                @endphp

                            <div class="col-md-12">
                                <div class="card mb-5 mb-lg-0">
                                    <div class="card-body">
                                        <h5 class="card-title text-muted text-uppercase text-center">{{$premium->title}}</h5>
                                        <h6 class="card-price text-center">R{{$premium->price}}<span class="period">/month</span></h6>
                                        <p class="text-center">Bill Monthly</p>
                                        <hr>
                                        <ul class="fa-ul">
                                            @foreach($premium->benefits as $benefit)
                                                <li><span class="fa-li"><i class="fas fa-check"></i></span>{{$benefit->name}}</li>
                                            @endforeach
                                        </ul>
                                        @if(auth()->user()->premium_subscription() && auth()->user()->premium_subscription()->subscription_id == $premium->id)
                                            <a href="javascript:;"  class="btn btn-block btn-primary text-uppercase">ACTIVE</a>
                                        @else
                                            <a href="javascript:;"  class="btn btn-block btn-primary text-uppercase buy loader-trigger" data-subscription-id="{{$premium->id}}">BUY</a>

                                        @endif
                                    </div>
                                </div>
                            </div>

                        @else
                                @foreach($subscriptions as $row)
                                    @if($row->title == 'Indie.Africa')
                                    @else
                                        <div class="col-md-4">
                                            <div class="card mb-5 mb-lg-0">
                                                <div class="card-body">
                                                    <h5 class="card-title text-muted text-uppercase text-center">{{$row->title}}</h5>
                                                    <h6 class="card-price text-center">R{{$row->price}}<span class="period">/month</span></h6>
                                                    <p class="text-center">Bill Monthly</p>
                                                    <hr>
                                                    <ul class="fa-ul">
                                                        @foreach($row->benefits as $benefit)
                                                            <li><span class="fa-li"><i class="fas fa-check"></i></span>{{$benefit->name}}</li>
                                                        @endforeach
                                                    </ul>
                                                    @if(auth()->user()->active_subscription() && auth()->user()->active_subscription()->subscription_id == $row->id)
                                                        <a href="javascript:;"  class="btn btn-block btn-primary text-uppercase">ACTIVE</a>
                                                    @else
                                                        <a href="javascript:;"  class="btn btn-block btn-primary text-uppercase buy loader-trigger" data-subscription-id="{{$row->id}}">BUY</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                        @endif
                </div>

                <form action="https://www.payfast.co.za/eng/process" method="POST" id="form-payment">

                    <input type="hidden" name="merchant_id" value="{{env('PAYFAST_MERCHANT_ID')}}">
                    <input type="hidden" name="merchant_key" value="{{env('PAYFAST_MERCHANT_KEY')}}">
                    <input type="hidden" name="return_url" value="{{route('author.subscriptions.success')}}">
                    <input type="hidden" name="cancel_url" value="{{route('author.subscriptions.cancel')}}">
                    <input type="hidden" name="notify_url" value="{{route('author.subscriptions.itn')}}">
                    <input type="hidden" name="name_first" value="{{trim(auth()->user()->first_name)}}">
                    <input type="hidden" name="name_last" value="{{trim(auth()->user()->last_name)}}">
                    <input type="hidden" name="email_address" value="{{trim(auth()->user()->email)}}">
                    <input type="hidden" name="m_payment_id" id="m_payment_id">
                    <input type="hidden" name="amount" id="amount">
                    <input type="hidden" name="item_name" id="item_name">
                    <input type="hidden" name="custom_int1" id="custom_int1">
                    <input type="hidden" name="subscription_type" value="1">
                    <input type="hidden" name="billing_date" id="billing_date" value="2019-11-01">
                    <input type="hidden" name="recurring_amount" id="recurring_amount">
                    <input type="hidden" name="frequency" value="3">
                    <input type="hidden" name="cycles" value="0">
                    <input type="hidden" name="signature" id="signature">
                </form>
            </div>
        </section>
    </div>
    <!-- end #content -->
    <script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
    <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
    <script src="{{asset('/author/assets/libs/md5/md5-min.js')}}"></script>

    <script>
        $('.buy').on('click', function () {
            var subscription_id = $(this).attr('data-subscription-id');
            //$(this).css('cursor','wait');
            $.post("{{route('author.subscriptions.store')}}",
                {subscription_id : subscription_id, _token : "{{csrf_token()}}"},
                function(data){
                    console.log(data);
                    $('#m_payment_id').val(data.order_id);
                    $('#amount').val(data.order_cost);
                    $('#recurring_amount').val(data.order_cost);
                    $('#item_name').val(data.item_name);
                    $('#custom_int1').val(data.subscription_id);
                    $('#billing_date').val(data.next_subscription_billing_date);

                    //serialize form
                    var form_data = $('input[name!=signature]','#form-payment').serialize()
                    //Add passphrase
                    form_data += '&passphrase=' + encodeURIComponent("{{env('PAYFAST_SUBSCRIPTION_PASSPHRASE')}}");
                    $('#signature').val(hex_md5(form_data));

                    $('#form-payment').submit();
                }
            );

        });
    </script>
@endsection
