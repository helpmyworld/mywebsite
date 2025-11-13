@extends('layouts.authorLayout.author_design')

@section('content')
    @include('layouts.response')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Manuscript</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('author.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payment</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0">Manuscript Payment</h5>
                    </div>
                    <div class="card-body">
                        <div class="widget-box">
                            <div class="widget-content nopadding">
                                <div class="panel panel-inverse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12">
                                                <h3 align="center">Pay online with your credit card</h3>
                                                <hr>
                                                <div class="note note-danger note-with-left-icon">
                                                    <div class="note-icon"><i class="fa fa-lightbulb"></i></div>
                                                    <div class="note-content text-left">
                                                        <h4><b>*Please Note</b></h4>
                                                        <p> You are only paying for this service</p>
                                                    </div>
                                                </div>

                                                <h5 align="center">Your Manuscript Information</h5>
                                                <hr style="">
                                                <table class="table">
                                                    <tbody>
                                                    <tr class="info">
                                                        <th>Manuscript Title:</th>
                                                        <td>{{$manuscript->title}}</td>
                                                    </tr>
                                                    <tr class="active">
                                                        <th>Amount Due:</th>
                                                        <td>R {{$manuscript->cost}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <br/>
                                                <form action="https://www.payfast.co.za/eng/process" method="POST" id="form-payment">
                                                    <input type="hidden" name="merchant_id" value="{{env('PAYFAST_MERCHANT_ID')}}">
                                                    <input type="hidden" name="merchant_key" value="{{env('PAYFAST_MERCHANT_KEY')}}">
                                                    <input type="hidden" name="return_url" value="{{route('author.manuscript.payments.success')}}">
                                                    <input type="hidden" name="cancel_url" value="{{route('author.manuscript.payments.cancel',['id'=>$manuscript->id])}}">
                                                    <input type="hidden" name="notify_url" value="{{route('author.manuscript.payments.itn')}}">
                                                    <input type="hidden" name="name_first" value="{{trim(auth()->user()->first_name)}}">
                                                    <input type="hidden" name="name_last" value="{{trim(auth()->user()->last_name)}}">
                                                    <input type="hidden" name="email_address" value="{{trim(auth()->user()->email)}}">
                                                    <input type="hidden" name="m_payment_id" id="m_payment_id" value="">
                                                    <input type="hidden" name="amount" id="amount" value="{{$manuscript->cost}}">
                                                    <input type="hidden" name="item_name" id="item_name" value="{{preg_replace('/\s+/', '', $manuscript->title)}}">
                                                    <input type="hidden" name="custom_int1" id="custom_int1" value="{{$manuscript->id}}">
                                                    <input type="hidden" name="signature" id="signature">

                                                </form>
                                                <input type="submit" class="btn btn-success btn-block" id="pay" value="Pay Now">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->


        <script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
        <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
            <script src="{{asset('/author/assets/libs/md5/md5-min.js')}}"></script>
            <script>
                $('#pay').on('click', function () {

                    var manuscript_id = "{{$manuscript->id}}";
                    //$(this).css('cursor','wait');
                    $.post("{{route('author.manuscript.payments.store')}}",
                        {manuscript_id : manuscript_id, _token : "{{csrf_token()}}"},
                        function(data){
                            console.log(data);
                            $('#m_payment_id').val(data.order_id);

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


