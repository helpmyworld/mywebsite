@extends('layouts.frontLayout.front_design')

@section('content')

    <!-- begin #content -->
    <div id="contact-page" id="container">
        <!-- begin breadcrumb -->

        <div class="bg">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="title text-center">Software and Apps <strong></strong></h2>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="services-full-width-container">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 special">
                                    <h3>We offer amazing Software and App Development and Designs!</h3>
                                    <br>
                                    <p style="text-align: center">Choose a website or app package based on your business needs.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="col-md-12">
                    <div class="services-full-width-container">
                        <div class="container">
                            <div class="row">
                                @foreach($websites as $row)
                                    <div class="col-md-4" style="margin-top: 30px ">
                                        <div class="card mb-5 mb-lg-0" >
                                            <div class="card-body">
                                                <h3 class="card-title  text-uppercase text-center" style="background-color:#50bfb6; color:#fff"><b>{{$row->title}}</b></h3>
                                                <h6 class="card-price text-center"><b style="font-size: 18px">R{{$row->price}}</b><span class="period">/Once Off</span></h6>
                                                <p class="text-center"></p>
                                                <hr>
                                                <ul class="fa-ul">
                                                   
                                                    @foreach($row->works as $work)
                                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>{{$work->name}}</li>

                                                        <hr>
                                                    @endforeach
                                                </ul>

                                                @if(auth()->check())
                                                    @if(auth()->user()->active_subscription() && auth()->user()->active_subscription()->subscription_id == $row->id)
                                                        <a href="javascript:;"  class="btn btn-block btn-primary text-uppercase">ACTIVE</a>
                                                    @else
                                                        <a href="https://helpmyworldpublishing.co.za/contact"  class="btn btn-block btn-primary text-uppercase buy loader-trigger" >GET THIS DEAL</a>
                                                    @endif

                                                @else
                                                    <a href="https://helpmyworldpublishing.co.za/contact"  class="btn btn-block btn-primary text-uppercase buy loader-trigger" >GET THIS DEAL</a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>

                        </div>

                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->
    <script src="{{ asset('/js/backend_js/jquery.min.js') }} "></script>
    <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script>
    <script src="{{asset('/author/assets/libs/md5/md5-min.js')}}"></script>

@endsection
