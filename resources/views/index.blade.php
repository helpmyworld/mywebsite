@extends('layouts.frontLayout.front_design')

@section('content')
<body>
    <div class="site-wrapper" id="top">
        <!--=================================
        Hero Area
        ===================================== -->
        <section class="hero-area hero-slider-2">
            <div class="container">
                <div class="row align-items-lg-center">
                    <!--=================================
                    Slides start here
                    ===================================== -->
                    <div class="col-lg-8">
                        <div class="sb-slick-slider" data-slick-setting='{
                                "autoplay": true,
                                "autoplaySpeed": 8000,
                                "slidesToShow": 1,
                                "dots":true
                                }'>
                                 @foreach($banners as $banner)
                                 @php
                                     $bg = $banner->image && file_exists(public_path('images/frontend_images/banners/large/'.$banner->image))
                                         ? asset('images/frontend_images/banners/large/'.$banner->image)
                                         : ( $banner->image && file_exists(public_path('images/frontend_images/banners/large/'.$banner->image))
                                             ? asset('images/frontend_images/banners/large/'.$banner->image)
                                             : asset('images/frontend_images/banners/default.png') );
                                 @endphp

                                 <div class="single-slide bg-image bg-position-left bg-position-lg-center"
                                     data-bg="{{ $bg }}">
                                 <div class="home-content text-left text-md-center pl--30 pl-md--0">
                                     <div class="row">
                                     <div class="col-lg-7 col-xl-5 col-md-6 col-sm-6">
                                         <span class="title-small"></span>
                                         <h3>{{ $banner->title }}</h3>
                                         <p>{{ \Illuminate\Support\Str::limit($banner->description, 80, '…') }}<br></p>
                                         <!-- <a href="https://helpmyworldpublishing.com/books" class="btn btn-outlined--primary"></a> -->
                                     </div>
                                     </div>
                                 </div>
                                 </div>
                                @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4 mt--30 mt-lg--0">
                        <span class="price">FEATURED AUTHOR LEADERS & CEOs</span>

                           @if(isset($featuredAuthors) && $featuredAuthors->count() > 0)
                            <div class="sb-slick-slider hero-products-group-slider product-border-reset"
                                data-slick-setting='{
                                    "autoplay": true,
                                    "autoplaySpeed": 8000,
                                    "slidesToShow": 1,
                                    "rows": 2
                                }'
                                data-slick-responsive='[
                                    {"breakpoint":992, "settings": {"slidesToShow": 2,"rows":2}},
                                    {"breakpoint":768, "settings": {"slidesToShow": 1}},
                                    {"breakpoint":490, "settings": {"slidesToShow": 1}}
                                ]'>




                              @foreach($featuredAuthors as $author)
                                <div class="single-slide">
                                    <div class="product-card card-style-list">
                                        <div class="card-image">
                                            <a href="{{ route('author.public-profile', ['slug' => $author->slug]) }}">
                                               @php $img = $author->image && file_exists(public_path('images/backend_images/authors/medium/'.$author->image)) ? asset('images/backend_images/authors/medium/'.$author->image) : asset('images/users/default.png'); @endphp

                                                <img src="{{ $img }}" alt="{{ $author->name }}">
                                            </a>
                                        </div>
                                        <div class="product-card--body">
                                                <div class="product-header">
                                                <h3><a href="{{ route('author.public-profile', ['slug' => $author->slug]) }}">
                                                    {{ $author->name }}
                                                </a></h3>
                                                </div>
                                                <div class="price-block">
                                                    <p><a href="{{ route('author.public-profile', ['slug' => $author->slug]) }}">
                                                    {{ \Illuminate\Support\Str::words(strip_tags($author->bio), 4, '...') }}
                                                    </a></p>
                                                </div>

                                                <div class="mt-2">
                                                    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        @endif

                    </div>
                    <!--=================================
                    Slides end here
                    ===================================== -->
                </div>
            </div>
        </section>

        

        


        <!--=================================
        Home Features Section
        ===================================== -->
        <section class="mb--30">
            <div class="container">
                <div class="row">
                   
                </div>
            </div>
        </section>


        <!--=================================
        Promotion Section One
        ===================================== -->
        <section class="section-margin">
            <h2 class="sr-only">Promotion Section</h2>
            <div class="container">
                <div class="row space-db--30">
                    <div class="col-lg-6 mb--30">
                        <a href="" class="promo-image promo-overlay">
                            <img src="/frontend/image/bg-images/promo-banner-with-text.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-lg-6 mb--30">
                        <a href="" class="promo-image promo-overlay">
                            <img src="/frontend/image/bg-images/promo-banner-with-text-2.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </section>











<!--=================================
        Home Slider Tab
        ===================================== -->
        <section class="section-padding">
            <h2 class="sr-only">Home Tab Slider Section</h2>
            <div class="container">
                <div class="sb-custom-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="shop-tab" data-bs-toggle="tab" href="#shop" role="tab"
                                aria-controls="shop" aria-selected="true">
                                Featured Books
                            </a>
                            <span class="arrow-icon"></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="men-tab" data-bs-toggle="tab" href="#men" role="tab"
                                aria-controls="men" aria-selected="true">
                                New Arrivals
                            </a>
                            <span class="arrow-icon"></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="woman-tab" data-bs-toggle="tab" href="#woman" role="tab"
                                aria-controls="woman" aria-selected="false">
                                Best Sellers
                            </a>
                            <span class="arrow-icon"></span>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane show active" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                            <div class="product-slider multiple-row slider-border-multiple-row sb-slick-slider"
                                data-slick-setting='{
                                    "autoplay": true,
                                    "autoplaySpeed": 8000,
                                    "slidesToShow": 5,
                                    "rows": 1,
                                    "dots": true
                                }' data-slick-responsive='[
                                    {"breakpoint":1200, "settings": {"slidesToShow": 3} },
                                    {"breakpoint":768,  "settings": {"slidesToShow": 2} },
                                    {"breakpoint":480,  "settings": {"slidesToShow": 1} },
                                    {"breakpoint":320,  "settings": {"slidesToShow": 1} }
                                ]'>

                                @foreach($featuredProducts as $pro)
                                    @php
                                        $img = asset('/images/backend_images/product/small/'.$pro->image);
                                        $url = url('/product/'.$pro->slug);
                                        $authorName = $pro->product_author ?? '—';
                                        $price = (float)($pro->price ?? 0);
                                    @endphp

                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                <h3><a href="{{ $url }}">{{ $pro->product_name }}</a></h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $pro->product_name }}"></a>
                                                    <div class="hover-contents">
                                                        <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $pro->product_name }}"></a>
                                                        <div class="hover-btns">
                                                                <a href="" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                    <!-- changed: remove black, add gradient small cart -->
                                                                    <button class="add-to-cart cart-btn"
                                                                        data-id="{{ $pro->id }}"
                                                                        data-name="{{ $pro->product_name }}"
                                                                        data-code="{{ $pro->product_code }}"
                                                                        data-color="{{ $pro->product_color }}"
                                                                        data-price="{{ $pro->price }}"
                                                                        data-type="{{ $pro->type }}">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                
                                                                </a>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="price-block">
                                                    <span class="price">R {{ number_format($price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="tab-pane" id="men" role="tabpanel" aria-labelledby="men-tab">
                            @if(isset($newArrivals) && $newArrivals->count() > 0)
                                    <div class="product-slider multiple-row slider-border-multiple-row sb-slick-slider"
                                        data-slick-setting='{
                                            "autoplay": true,
                                            "autoplaySpeed": 8000,
                                            "slidesToShow": 5,
                                            "rows": 1,
                                            "dots": true
                                        }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 3} },
                                            {"breakpoint":768,  "settings": {"slidesToShow": 2} },
                                            {"breakpoint":480,  "settings": {"slidesToShow": 1} },
                                            {"breakpoint":320,  "settings": {"slidesToShow": 1} }
                                        ]'>

                                        @foreach($newArrivals as $pro)
                                            @php
                                                $img = asset('/images/backend_images/product/small/'.$pro->image);
                                                $url = url('/product/'.$pro->slug);
                                                $authorName = $pro->product_author ?? '—';
                                                $price = (float)($pro->price ?? 0);
                                            @endphp

                                            <div class="single-slide">
                                                <div class="product-card">
                                                    <div class="product-header">
                                                        <h3><a href="{{ $url }}">{{ $pro->product_name }}</a></h3>
                                                    </div>
                                                    <div class="product-card--body">
                                                        <div class="card-image">
                                                            <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $pro->product_name }}"></a>
                                                            <div class="hover-contents">
                                                                <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $pro->product_name }}"></a>
                                                                <div class="hover-btns">
                                                                     
                                                                    <a href="" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                    <!-- changed: remove black, add gradient small cart -->
                                                                    <button class="add-to-cart cart-btn"
                                                                        data-id="{{ $pro->id }}"
                                                                        data-name="{{ $pro->product_name }}"
                                                                        data-code="{{ $pro->product_code }}"
                                                                        data-color="{{ $pro->product_color }}"
                                                                        data-price="{{ $pro->price }}"
                                                                        data-type="{{ $pro->type }}">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                
                                                                </a>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="price-block">
                                                        <span class="price">R {{ number_format($price, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                @endif
                        </div>


                        <div class="tab-pane" id="woman" role="tabpanel" aria-labelledby="woman-tab">
                            @if(isset($bestSellers) && $bestSellers->count() > 0)
                                    <div class="product-slider multiple-row slider-border-multiple-row sb-slick-slider"
                                        data-slick-setting='{
                                            "autoplay": true,
                                            "autoplaySpeed": 8000,
                                            "slidesToShow": 5,
                                            "rows": 1,
                                            "dots": true
                                        }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 3} },
                                            {"breakpoint":768,  "settings": {"slidesToShow": 2} },
                                            {"breakpoint":480,  "settings": {"slidesToShow": 1} },
                                            {"breakpoint":320,  "settings": {"slidesToShow": 1} }
                                        ]'>

                                      @foreach($bestSellers as $pro)
                                            @php
                                                $img = asset('/images/backend_images/product/small/'.$pro->image);
                                                $url = url('/product/'.$pro->slug);
                                                $authorName = $pro->product_author ?? '—';
                                                $price = (float)($pro->price ?? 0);
                                            @endphp

                                            <div class="single-slide">
                                                <div class="product-card">
                                                    <div class="product-header">
                                                        <h3><a href="{{ $url }}">{{ $pro->product_name }}</a></h3>
                                                    </div>
                                                    <div class="product-card--body">
                                                        <div class="card-image">
                                                            <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $pro->product_name }}"></a>
                                                            <div class="hover-contents">
                                                                <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $pro->product_name }}"></a>
                                                                <div class="hover-btns">
                                                                     
                                                                   <a href="" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                    <!-- changed: remove black, add gradient small cart -->
                                                                    <button class="add-to-cart cart-btn"
                                                                        data-id="{{ $pro->id }}"
                                                                        data-name="{{ $pro->product_name }}"
                                                                        data-code="{{ $pro->product_code }}"
                                                                        data-color="{{ $pro->product_color }}"
                                                                        data-price="{{ $pro->price }}"
                                                                        data-type="{{ $pro->type }}">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                
                                                                </a>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="price-block">
                                                        <span class="price">R {{ number_format($price, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                @endif
                        </div>
                    </div>


                </div>
            </div>
        </section>






       



<div class="tab-content" id="myTabContent">

  

  {{-- =====================
       Tab 2: New Arrivals (YOUR CODE as-is, no changes)
  ====================== --}}
  <div class="tab-pane" id="men" role="tabpanel" aria-labelledby="men-tab">
    @if(isset($newArrivals) && $newArrivals->count() > 0)
    <div class="features_items">
      <h2 class="title text-center">New Arrivals</h2>
      <div class="row">
        @foreach($newArrivals as $pro)
        <div class="col-sm-3">
          <div class="product-image-wrapper">
            <div class="single-products">
              <div class="productinfo text-center">
                <a href="{{ url('/product/'.$pro->slug) }}">
                  <img src="{{ asset('/images/backend_images/product/small/'.$pro->image) }}" alt="">
                </a>
                <h2>R {{ $pro->price }}</h2>
                <a href="{{ url('/product/'.$pro->slug) }}"><p>{{ $pro->product_name }}</p></a>
                <button class="btn btn-default add-to-cart"
                    data-id="{{ $pro->id }}"
                    data-name="{{ $pro->product_name }}"
                    data-code="{{ $pro->product_code }}"
                    data-color="{{ $pro->product_color }}"
                    data-price="{{ $pro->price }}"
                    data-type="{{ $pro->type }}">
                  <i class="fa fa-shopping-cart"></i> Add to cart
                </button>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>

  {{-- =====================
       Tab 3: Best Sellers (grid, NO carousel)
       (Your code adapted to remove Bootstrap carousel)
  ====================== --}}
  <div class="tab-pane" id="woman" role="tabpanel" aria-labelledby="woman-tab">
    @if(isset($bestSellers) && $bestSellers->count() > 0)
    <div class="recommended_items">
      <h2 class="title text-center">Best Sellers</h2>
      <div class="row">
        @foreach($bestSellers as $pro)
        <div class="col-sm-4">
          <div class="product-image-wrapper">
            <div class="single-products">
              <div class="productinfo text-center">
                <a href="{{ url('/product/'.$pro->slug) }}">
                  <img src="{{ asset('/images/backend_images/product/small/'.$pro->image) }}" alt="">
                </a>
                <h2>R {{ $pro->price }}</h2>
                <a href="{{ url('/product/'.$pro->slug) }}"><p>{{ $pro->product_name }}</p></a>
                <a href="" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                    <!-- changed: remove black, add gradient small cart -->
                                                                    <button class="add-to-cart cart-btn"
                                                                        data-id="{{ $pro->id }}"
                                                                        data-name="{{ $pro->product_name }}"
                                                                        data-code="{{ $pro->product_code }}"
                                                                        data-color="{{ $pro->product_color }}"
                                                                        data-price="{{ $pro->price }}"
                                                                        data-type="{{ $pro->type }}">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                
                                                                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>

</div>

                    </div>
                </div>
            </div>
        </section>

        <!--=================================
        Home Two Column Section
        ===================================== -->


          <!--=================================
        Home Two Column Section
        ===================================== -->
        <section class="bg-gray section-padding-top section-padding-bottom section-margin">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 mb--30 mb-lg--0">
                        <div class="home-left-sidebar">
                            

                            <div class="single-side  bg-white">
                                <h2 class="home-sidebar-title">
                                    Special Offers
                                </h2>

                                @if(isset($specialOffers) && $specialOffers->count() > 0)

                                <div class="product-slider countdown-single with-countdown sb-slick-slider"
                                    data-slick-setting='{
                                        "autoplay": true,
                                        "autoplaySpeed": 8000,
                                        "slidesToShow": 1,
                                        "dots":true
                                    }' data-slick-responsive='[
                                        {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                        {"breakpoint":480, "settings": {"slidesToShow": 1} }
                                    ]'>

                                    @foreach($specialOffers as $pro)
                                    @php
                                        $url  = url('/product/'.$pro->slug);
                                        $img  = asset('/images/backend_images/product/small/'.$pro->image);
                                        $name = $pro->product_name ?? 'Book';
                                        $author = $pro->product_author ?? '';
                                        $price  = (float)($pro->price ?? 0);
                                    @endphp

                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                
                                              <h3><a href="{{ $url }}">{{ $name }}</a></h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <a href="{{ $url }}" class="hover-image"> <img src="{{ $img }}" alt="{{ $name }}">  </a>
                                                <div class="hover-contents">
                                                        
                                                <a href="{{ $url }}" class="hover-image"><img src="{{ $img }}" alt="{{ $name }}">  </a>


                                                        <div class="hover-btns">
                                                            <a href="" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                    <!-- changed: remove black, add gradient small cart -->
                                                                    <button class="add-to-cart cart-btn"
                                                                        data-id="{{ $pro->id }}"
                                                                        data-name="{{ $pro->product_name }}"
                                                                        data-code="{{ $pro->product_code }}"
                                                                        data-color="{{ $pro->product_color }}"
                                                                        data-price="{{ $pro->price }}"
                                                                        data-type="{{ $pro->type }}">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                
                                                                </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                                                   <span class="price">R {{ number_format($price, 2) }}</span>
                                                </div>
                                                <div class="count-down-block">
                                                    <div class="product-countdown" data-countdown="01/05/2020"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                 @endif
                            </div>
                            <div class="single-side">
                                <a href="#" class="promo-image promo-overlay">
                                    <img src="/frontend/image/bg-images/promo-banner-small-with-text.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="home-right-block">
                            <div class="single-block bg-white">
                                <div class="section-title mt-0">
                                    <h2>MEMOIR & BIOGRAPHIES BOOKS</h2>
                                </div>

                                @if(isset($biographyBooks) && $biographyBooks->count() > 0)
                                <div class="product-slider product-list-slider sb-slick-slider slider-border-single-row"
                                    data-slick-setting='{
                                                                    "autoplay": true,
                                                                    "autoplaySpeed": 8000,
                                                                    "slidesToShow":2,
                                                                    "dots":true
                                                                }' data-slick-responsive='[
                                                                    {"breakpoint":1200, "settings": {"slidesToShow": 2} },
                                                                    {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                                                    {"breakpoint":768, "settings": {"slidesToShow": 2} },
                                                                    {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                                                    {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                                                ]'>

                                    @foreach($biographyBooks as $pro)
                                    @php
                                      $img = asset('/images/backend_images/product/small/' . $pro->image);
                                      $url = url('/product/' . $pro->slug);
                                      $authorName = $pro->product_author ?? '—';
                                      $price = (float)($pro->price ?? 0);
                                    @endphp
                                    <div class="single-slide">
                                        <div class="product-card card-style-list">
                                            <div class="card-image">
                                                <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $pro->product_name }}"></a>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="product-header">
                                                    <div class="hover-btns">
                                                           <a href="" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                    <!-- changed: remove black, add gradient small cart -->
                                                                    <button class="add-to-cart cart-btn"
                                                                        data-id="{{ $pro->id }}"
                                                                        data-name="{{ $pro->product_name }}"
                                                                        data-code="{{ $pro->product_code }}"
                                                                        data-color="{{ $pro->product_color }}"
                                                                        data-price="{{ $pro->price }}"
                                                                        data-type="{{ $pro->type }}">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                
                                                                </a>
                                                        </div>
                                                    <h3><a href="{{ $url }}">{{ $pro->product_name }}</a></h3>
                                                </div>
                                                <div class="price-block">
                                                    <span class="price">R {{ number_format($price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     @endforeach


                                </div>
                                @endif
                            </div>
                            <div class="single-block bg-white">
                                <div class="section-title mt-0">
                                    <h2>ARTS & PHOTOGRAPHY BOOKS</h2>
                                </div>

                                @if(isset($novelBooks) && $novelBooks->count() > 0)
                                <div class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
                                        
                                        "autoplaySpeed": 8000,
                                        "slidesToShow": 3,
                                        "dots":true
                                    }' data-slick-responsive='[
                                        {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                        {"breakpoint":768, "settings": {"slidesToShow": 2} },
                                        {"breakpoint":480, "settings": {"slidesToShow": 1} },
                                        {"breakpoint":320, "settings": {"slidesToShow": 1} }
                                    ]'>

                                    @foreach($novelBooks as $pro)
                                    @php
                                        $img       = asset('/images/backend_images/product/small/'.$pro->image);
                                        $url       = url('/product/'.$pro->slug);
                                        $author    = $pro->product_author ?? '—';
                                        $price     = (float)($pro->price ?? 0);
                                        $title     = $pro->product_name ?? 'Book';
                                    @endphp

                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                
                                               <h3><a href="{{ $url }}">{{ $title }}</a></h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $title }}"></a>                                                    <div class="hover-contents">
                                                        <a href="{{ $url }}" class="hover-image">
                                                            <img src="{{ $img }}" alt="{{ $title }}">
                                                        </a>


                                                        <div class="hover-btns">
                                                           <a href="" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                    <!-- changed: remove black, add gradient small cart -->
                                                                    <button class="add-to-cart cart-btn"
                                                                        data-id="{{ $pro->id }}"
                                                                        data-name="{{ $pro->product_name }}"
                                                                        data-code="{{ $pro->product_code }}"
                                                                        data-color="{{ $pro->product_color }}"
                                                                        data-price="{{ $pro->price }}"
                                                                        data-type="{{ $pro->type }}">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                
                                                                </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                    <span class="price">R {{ number_format($price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                     @endforeach

                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
     


<!--=================================
        CHILDREN’S BOOKS SECTION
        ===================================== -->
        <section class="section-margin">
            <div class="container">
                <div class="section-title section-title--bordered">
                    <h2>CHILDREN’S BOOKS</h2>
                </div>

                @if(isset($childrenBooks) && $childrenBooks->count() > 0)
                <div class="product-slider product-list-slider slider-border-single-row sb-slick-slider"
                    data-slick-setting='{
                                            "autoplay": true,
                                            "autoplaySpeed": 8000,
                                            "slidesToShow":3,
                                            "dots":true
                                        }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                        ]'>

                @foreach($childrenBooks as $pro)
                  @php
                    $img = asset('/images/backend_images/product/small/' . $pro->image);
                    $url = url('/product/' . $pro->slug);
                    $authorName = $pro->product_author ?? '—';
                    $price = (float)($pro->price ?? 0);
                  @endphp
                    

                    <div class="single-slide">
                        <div class="product-card card-style-list">
                            <div class="card-image">
                                <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $pro->product_name }}"></a>
                            </div>
                            <div class="product-card--body">
                                <div class="product-header">
                                    <a href="" class="author">
                                    </a>
                                        <h3><a href="product-details.html"> {{ $pro->product_name }}</a>
                                        </h3>

                                        <div class="hover-btns">
                                                           <a href="" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                    <!-- changed: remove black, add gradient small cart -->
                                                                    <button class="add-to-cart cart-btn"
                                                                        data-id="{{ $pro->id }}"
                                                                        data-name="{{ $pro->product_name }}"
                                                                        data-code="{{ $pro->product_code }}"
                                                                        data-color="{{ $pro->product_color }}"
                                                                        data-price="{{ $pro->price }}"
                                                                        data-type="{{ $pro->type }}">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                </a>
                                                                <a href="#" class="single-btn">
                                                                
                                                                </a>
                                                        </div>
                                </div>
                                <div class="price-block">
                                    <span class="price">R {{ number_format($price, 2) }}</span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                @endforeach

            </div>
            @endif
          </div>
        </section>



        <!--=================================
        Promotion Section Two
        ===================================== -->
        <section class="section-margin">
            <h2 class="sr-only">Promotion Section</h2>
            <div class="container">
                <div class="promo-wrapper promo-type-four">
                    <a href="#" class="promo-image promo-overlay bg-image"
                        data-bg="/frontend/image/bg-images/promo-banner-contained.jpg">
                        <!-- <img src="image/bg-images/promo-banner-contained.jpg" alt="" class="w-100 h-100"> -->
                    </a>
                    <div class="promo-text w-100 justify-content-center justify-content-md-left">
                        <div class="row w-100">
                            <div class="col-lg-8">
                                <div class="promo-text-inner">
                                    <h2>Buy 3 Books. Get Free 1.</h2>
                                    <h3></h3>
                                    <a href="#" class="btn btn-outlined--red-faded">See More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>




<!--=================================
        Home Blog
        ===================================== -->
        <section class="section-margin">
            <div class="container">
                <div class="section-title">
                    <h2>LATEST BLOGS</h2>
                </div>


    @if(isset($posts) && $posts->count() > 0)
                <div class="blog-slider sb-slick-slider" data-slick-setting='{
                "autoplay": true,
                "autoplaySpeed": 8000,
                "slidesToShow": 2,
                "dots": true
            }' data-slick-responsive='[
                {"breakpoint":1200, "settings": {"slidesToShow": 1} }
            ]'>


             @foreach($posts as $post)
                    <div class="single-slide">
                        <div class="blog-card">
                            <div class="image">
                                <a href="{{ route('blog.single', $post->slug) }}">
                                @if(!empty($post->image))
                                <img src="{{ asset('/images/' . $post->image) }}" alt="{{ $post->title }}"  width="320" >
                                @endif
                                </a>
                            </div>
                            <div class="content">
                                <div class="content-header">
                                    <div class="date-badge">
                                        <span class="date">{{ $post->created_at->format('d') }}</span>
                                        <span class="month">{{ $post->created_at->format('M') }}</span>
                                    </div>
                                    <h3 class="title"><a href="{{ route('blog.single', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                </div>
                                <p class="meta-para">
                                    <i class="fas fa-user-edit"></i>
                                    Post by
                                    <a href="#">
                                        @if($post->user) {{ $post->user->name }} @else {{ $post->admin->username }} @endif
                                    </a>
                                </p>

                                <article class="blog-paragraph">
                                    <h2 class="sr-only">blog-paragraph</h2>
                                    <p>{!! substr($post->body,0,200) !!}{{ strlen($post->body)>200?"...":"" }}</p>
                                </article>

                                <a href="{{ route('blog.single', $post->slug) }}" class="card-link">
                                    Read More <i class="fas fa-chevron-circle-right"></i>
                                </a>

                                <span class="d-block mt-2">
                                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                    <div class="addthis_inline_share_toolbox_e4f5"></div>
                                </span>

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                @endif

            </div>
        </section>

        <!--=================================
        Home Blog
        ===================================== -->
       








        <!-- Modal -->
        <div class="modal fade modal-quick-view" id="quickModal" tabindex="-1" role="dialog"
            aria-labelledby="quickModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="product-details-modal">
                        <div class="row">
                            <div class="col-lg-5">
                                <!-- Product Details Slider Big Image-->
                                <div class="product-details-slider sb-slick-slider arrow-type-two" data-slick-setting='{
                                    "slidesToShow": 1,
                                    "arrows": false,
                                    "fade": true,
                                    "draggable": false,
                                    "swipe": false,
                                    "asNavFor": ".product-slider-nav"
                                    }'>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-1.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-2.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-3.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-4.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-5.jpg" alt="">
                                    </div>
                                </div>
                                <!-- Product Details Slider Nav -->
                                <div class="mt--30 product-slider-nav sb-slick-slider arrow-type-two"
                                    data-slick-setting='{
            "infinite":true,
              "autoplay": true,
              "autoplaySpeed": 8000,
              "slidesToShow": 4,
              "arrows": true,
              "prevArrow":{"buttonClass": "slick-prev","iconClass":"fa fa-chevron-left"},
              "nextArrow":{"buttonClass": "slick-next","iconClass":"fa fa-chevron-right"},
              "asNavFor": ".product-details-slider",
              "focusOnSelect": true
              }'>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-1.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-2.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-3.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-4.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-5.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 mt--30 mt-lg--30">
                                <div class="product-details-info pl-lg--30 ">
                                    <p class="tag-block">Tags: <a href="#">Movado</a>, <a href="#">Omega</a></p>
                                    <h3 class="product-title">Beats EP Wired On-Ear Headphone-Black</h3>
                                    <ul class="list-unstyled">
                                        <li>Ex Tax: <span class="list-value"> £60.24</span></li>
                                        <li>Brands: <a href="#" class="list-value font-weight-bold"> Canon</a></li>
                                        <li>Product Code: <span class="list-value"> model1</span></li>
                                        <li>Reward Points: <span class="list-value"> 200</span></li>
                                        <li>Availability: <span class="list-value"> In Stock</span></li>
                                    </ul>
                                    <div class="price-block">
                                        <span class="price-new">£73.79</span>
                                        <del class="price-old">£91.86</del>
                                    </div>
                                    <div class="rating-widget">
                                        <div class="rating-block">
                                            <span class="fas fa-star star_on"></span>
                                            <span class="fas fa-star star_on"></span>
                                            <span class="fas fa-star star_on"></span>
                                            <span class="fas fa-star star_on"></span>
                                            <span class="fas fa-star "></span>
                                        </div>
                                        <div class="review-widget">
                                            <a href="">(1 Reviews)</a> <span>|</span>
                                            <a href="">Write a review</a>
                                        </div>
                                    </div>
                                    <article class="product-details-article">
                                        <h4 class="sr-only">Product Summery</h4>
                                        <p>Long printed dress with thin adjustable straps. V-neckline and wiring under
                                            the Dust with ruffles
                                            at the bottom
                                            of the
                                            dress.</p>
                                    </article>
                                    <div class="add-to-cart-row">
                                        <div class="count-input-block">
                                            <span class="widget-label">Qty</span>
                                            <input type="number" class="form-control text-center" value="1">
                                        </div>
                                        <div class="add-cart-btn">
                                            <a href="" class="btn btn-outlined--primary"><span
                                                    class="plus-icon">+</span>Add to Cart</a>
                                        </div>
                                    </div>
                                    <div class="compare-wishlist-row">
                                        <a href="" class="add-link"><i class="fas fa-heart"></i>Add to Wish List</a>
                                        <a href="" class="add-link"><i class="fas fa-random"></i>Add to Compare</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="widget-social-share">
                            <span class="widget-label">Share:</span>
                            <div class="modal-social-share">
                                <a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
                                <a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=================================
        Footer
        ===================================== -->
    </div>
        <!--=================================
        Brands Slider
        ===================================== -->
        <section class="section-margin">
            <h2 class="sr-only">Brand Slider</h2>
            <div class="container">
                <div class="brand-slider sb-slick-slider border-top border-bottom" data-slick-setting='{
                                                "autoplay": true,
                                                "autoplaySpeed": 8000,
                                                "slidesToShow": 6
                                                }' data-slick-responsive='[
                    {"breakpoint":992, "settings": {"slidesToShow": 4} },
                    {"breakpoint":768, "settings": {"slidesToShow": 3} },
                    {"breakpoint":575, "settings": {"slidesToShow": 3} },
                    {"breakpoint":480, "settings": {"slidesToShow": 2} },
                    {"breakpoint":320, "settings": {"slidesToShow": 1} }
                ]'>
                    <div class="single-slide">
                        <img src="image/others/Banner Ad.jpg" alt="">
                    </div>
                    
                </div>
            </div>
        </section>
         <!-- Use Minified Plugins Version For Fast Page Load -->

        <!-- Toast -->
        <div id="toast" class="toast-message">🛒 Added to cart!</div>

        <!-- Minimal styles for the nicer small cart button + toast -->
        <style>
            /* small gradient circular cart button (replaces the black btn-dark) */
            .cart-btn{
                background: linear-gradient(135deg,#00a3c4,#2dd4bf);
                color:#fff !important;
                border:none;
                width:38px;height:38px;border-radius:50%;
                display:inline-flex;align-items:center;justify-content:center;
                transition:transform .18s ease, box-shadow .18s ease, opacity .18s ease;
                opacity:.95
            }
            .cart-btn:hover{transform:scale(1.1);box-shadow:0 6px 16px rgba(0,163,196,.35);opacity:1}

            /* toast */
            .toast-message{
                visibility:hidden;opacity:0;
                position:fixed;left:50%;bottom:40px;transform:translateX(-50%);
                background:#00a3c4;color:#fff;padding:12px 18px;border-radius:10px;
                box-shadow:0 10px 25px rgba(0,0,0,.15);z-index:9999;font-weight:600;
                transition:opacity .3s ease, bottom .3s ease, visibility 0s .3s
            }
            .toast-message.show{visibility:visible;opacity:1;bottom:60px;transition:opacity .3s ease,bottom .3s ease}
        </style>

        <!-- Vanilla JS add-to-cart (no alert; shows toast). Tabs untouched. -->
        <script>
        (function(){
            function showToast(msg){
                var t=document.getElementById('toast');
                if(!t) return;
                t.textContent=msg;
                t.classList.add('show');
                setTimeout(function(){ t.classList.remove('show'); }, 2200);
            }

            document.addEventListener('click', function(e){
                var btn = e.target.closest('.add-to-cart');
                if(!btn) return;
                e.preventDefault();

                btn.disabled = true;

                var data = new FormData();
                data.append('_token', '{{ csrf_token() }}');
                data.append('product_id',  btn.dataset.id);
                data.append('product_name',btn.dataset.name);
                data.append('product_code',btn.dataset.code);
                data.append('product_color',btn.dataset.color);
                data.append('price',       btn.dataset.price);
                data.append('product_type',btn.dataset.type);
                data.append('quantity',    1);

                fetch("{{ url('add-cart') }}", {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: data
                })
                .then(function(r){ return r.json().catch(function(){ return {}; }); })
                .then(function(res){
                    if(res && typeof res.cart_count !== 'undefined'){
                        var cc=document.getElementById('cart-count');
                        if(cc) cc.textContent = res.cart_count;
                    }
                    showToast('✅ Added to cart successfully!');
                })
                .catch(function(err){
                    showToast('❌ Error adding to cart.');
                })
                .finally(function(){ btn.disabled=false; });
            }, false);
        })();
        </script>

</body>

@endsection
