@extends('layouts.frontLayout.front_design')

@section('content')



    <section>
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Books</li>
                </ol>
            </div><!--/breadcrums-->

            <div class="shopper-informations">
                <div class="row">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    @include('layouts.frontLayout.front_sidebar')
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <ul id="flexiselDemo3">
                            <h2 class="title text-center">Latest Ebooks </h2>
                            @foreach($productsAll as $pro)
                                <li>
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <a href="{{ url('/product/'.$pro->slug) }}"><img src="{{ asset('/images/backend_images/product/small/'.$pro->image) }}" alt="" /></a>
                                                    <h2>R {{ $pro->price }}</h2>
                                                    <a href="{{ url('/product/'.$pro->slug) }}"><p>{{ $pro->product_name }}</p></a>
                                                    <a href="{{ url('/product/'.$pro->slug) }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                </div>

                                                {{--<div class="product-overlay">--}}
                                                {{--<div class="overlay-content">--}}
                                                {{--<h2>R {{ $pro->price }}</h2>--}}
                                                {{--<a href="{{ url('/product/'.$pro->id) }}"><p>{{ $pro->product_name }}</p></a>--}}
                                                {{--<a href="{{ url('/product/'.$pro->id) }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                            </div>
                                            {{--<div class="choose">--}}
                                            {{--<ul class="nav nav-pills nav-justified">--}}
                                            {{--<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>--}}
                                            {{--<li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>--}}
                                            {{--</ul>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <script type="text/javascript">
                            $(window).load(function() {
                                $("#flexiselDemo3").flexisel({
                                    visibleItems: 3,
                                    itemsToScroll: 1,
                                    autoPlay: {
                                        enable: true,
                                        interval: 5000,
                                        pauseOnHover: true
                                    }
                                });

                                // $("#flexiselDemo2").flexisel({
                                //     visibleItems:4,
                                //     animationSpeed: 1000,
                                //     autoPlay: true,
                                //     autoPlaySpeed: 3000,
                                //     pauseOnHover: true,
                                //     enableResponsiveBreakpoints: true,
                                //     responsiveBreakpoints: {
                                //         portrait: {
                                //             changePoint:480,
                                //             visibleItems: 1
                                //         },
                                //         landscape: {
                                //             changePoint:640,
                                //             visibleItems:2
                                //         },
                                //         tablet: {
                                //             changePoint:768,
                                //             visibleItems: 3
                                //         }
                                //     }
                                // });

                            });
                        </script>
                        <script type="text/javascript" src="/public/js/jquery.flexisel.js"></script>

                    </div><!--features_items-->

                </div>
            </div>
        </div>
    </section>

@endsection
