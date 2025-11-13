@extends('layouts.frontLayout.front_design')

@section('content')
<div class="site-wrapper" id="top">

    {{-- =========================
        BREADCRUMB (Pustok style)
    ========================== --}}
    <section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/books') }}">Books</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $productDetails->product_name }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- =========================
        MAIN PRODUCT DETAILS (Pustok layout)
    ========================== --}}
    <main class="inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row mb--60">
                {{-- LEFT: IMAGE SLIDER, styled like product-details.html --}}
                <div class="col-lg-5 mb--30">

                    {{-- BIG SLIDER --}}
                    <div class="product-details-slider sb-slick-slider arrow-type-two"
                         data-slick-setting='{
                            "slidesToShow": 1,
                            "arrows": false,
                            "fade": true,
                            "draggable": false,
                            "swipe": false,
                            "asNavFor": ".product-slider-nav"
                         }'>

                        {{-- Main image --}}
                        <div class="single-slide">
                            <img src="{{ asset('/images/backend_images/product/large/'.$productDetails->image) }}"
                                 alt="{{ $productDetails->product_name }}">
                        </div>

                        {{-- Alt images as extra slides --}}
                        @if(!empty($productAltImages) && count($productAltImages) > 0)
                            @foreach($productAltImages as $altimg)
                                <div class="single-slide">
                                    <img src="{{ asset('images/backend_images/product/large/'.$altimg->image) }}"
                                         alt="{{ $productDetails->product_name }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- THUMB NAV SLIDER --}}
                    <div class="mt--30 product-slider-nav sb-slick-slider arrow-type-two"
                         data-slick-setting='{
                            "infinite": true,
                            "autoplay": true,
                            "autoplaySpeed": 8000,
                            "slidesToShow": 4,
                            "arrows": true,
                            "prevArrow": {"buttonClass": "slick-prev","iconClass":"fa fa-chevron-left"},
                            "nextArrow": {"buttonClass": "slick-next","iconClass":"fa fa-chevron-right"},
                            "asNavFor": ".product-details-slider",
                            "focusOnSelect": true
                         }'>

                        {{-- Main thumb --}}
                        <div class="single-slide">
                            <img src="{{ asset('/images/backend_images/product/small/'.$productDetails->image) }}"
                                 alt="{{ $productDetails->product_name }}">
                        </div>

                        {{-- Alt thumbs --}}
                        @if(!empty($productAltImages) && count($productAltImages) > 0)
                            @foreach($productAltImages as $altimg)
                                <div class="single-slide">
                                    <img src="{{ asset('images/backend_images/product/small/'.$altimg->image) }}"
                                         alt="{{ $productDetails->product_name }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- RIGHT: PRODUCT INFO, styled like product-details.html but with your data & form --}}
                <div class="col-lg-7">
                    <div class="product-details-info pl-lg--30">

                        {{-- TAGS / META --}}
                        <p class="tag-block">
                            @php
                                $author = $productDetails->product_author ?? null;
                            @endphp
                            @if($author)
                                Author:
                                <a href="#" class="font-weight-bold">{{ $author }}</a>
                            @else
                                <span>&nbsp;</span>
                            @endif
                        </p>

                        <h3 class="product-title">{{ $productDetails->product_name }}</h3>

                        <ul class="list-unstyled">
                            <!-- <li>
                                Product Code:
                                <span class="list-value">{{ $productDetails->product_code }}</span>
                            </li>
                            <li>
                                Availability:
                                <span class="list-value">
                                    @if($total_stock > 0) In Stock @else Out Of Stock @endif
                                </span>
                            </li> -->
                        </ul>

                        {{-- PRICE BLOCK (Pustok style, R instead of £) --}}
                        <div class="price-block">
                            <span class="price-new">
                                R {{ number_format($productDetails->price, 2) }}
                            </span>
                        </div>

                        {{-- Simple static rating widget (purely visual) --}}
                        <div class="rating-widget">
                            <div class="rating-block">
                                <span class="fas fa-star star_on"></span>
                                <span class="fas fa-star star_on"></span>
                                <span class="fas fa-star star_on"></span>
                                <span class="fas fa-star star_on"></span>
                                <span class="fas fa-star"></span>
                            </div>
                            <div class="review-widget">
                                <a href="javascript:void(0)">(No Reviews Yet)</a>
                            </div>
                        </div>

                        {{-- DESCRIPTION / SUMMARY --}}
                        <article class="product-details-article">
                            <h4 class="sr-only">Product Summary</h4>
                            @if(!empty($productDetails->description))
                                <p>{!! $productDetails->description !!}</p>
                            @endif
<!-- 
                            @if(!empty($productDetails->care))
                                <p class="mt-2"><strong>Material &amp; Care:</strong> {{ $productDetails->care }}</p>
                            @endif -->
                        </article>

                        {{-- ==============================
                             WORKING ADD-TO-CART FORM
                           ============================== --}}
                        <form name="addtoCartForm" id="addtoCartForm"
                              action="{{ url('add-cart') }}" method="post">
                            {{ csrf_field() }}

                            {{-- original hidden fields --}}
                            <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                            <input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
                            <input type="hidden" name="product_code" value="{{ $productDetails->product_code }}">
                            <input type="hidden" name="product_color" value="{{ $productDetails->product_color }}">
                            <input type="hidden" name="price" id="price" value="{{ $productDetails->price }}">

                            {{-- SIZE SELECT (styled to sit nicely in Pustok layout) --}}
                            @if($productDetails->attributes && $productDetails->attributes->count())
                                <div class="mt-3 mb-3">
                                    <label for="selSize" class="widget-label d-block mb-1">
                                        Select Size
                                    </label>
                                    <select id="selSize" name="size"
                                            class="form-control w-auto d-inline-block"
                                            required>
                                        <option value="">Select</option>
                                        @foreach($productDetails->attributes as $sizes)
                                            <option value="{{ $productDetails->id }}-{{ $sizes->size }}">
                                                {{ $sizes->size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            {{-- Qty + Add to Cart (exact Pustok layout, but using your button behaviour) --}}
                            <div class="add-to-cart-row">
                                <div class="count-input-block">
                                    <span class="widget-label">Qty</span>
                                    <input type="number" name="quantity"
                                           class="form-control text-center"
                                           value="1" min="1">
                                </div>
                                <div class="add-cart-btn">
                                    @if($total_stock > 0)
                                        {{-- visually same as theme; JS intercepts submit --}}
                                        <button type="submit"
                                                class="btn btn-outlined--primary"
                                                id="cartButton">
                                            <span class="plus-icon">+</span>
                                            Add to Cart
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-outlined--primary"
                                                disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>

                        {{-- wishlist/compare row (just visual, no functionality changed here) --}}
                        <div class="compare-wishlist-row mt-3">
                            <a href="javascript:void(0)" class="add-link">
                                <i class="fas fa-heart"></i>
                                Add to Wish List
                            </a>
                            <a href="javascript:void(0)" class="add-link">
                                <i class="fas fa-random"></i>
                                Add to Compare
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            {{-- =========================
                 TABS (DESCRIPTION / DETAILS)
               ========================== --}}
            <div class="sb-custom-tab review-tab section-padding">
                <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"
                           id="tab1" data-bs-toggle="tab"
                           href="#tab-1" role="tab"
                           aria-controls="tab-1" aria-selected="true">
                            DESCRIPTION
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="tab2" data-bs-toggle="tab"
                           href="#tab-2" role="tab"
                           aria-controls="tab-2" aria-selected="false">
                            ADDITIONAL INFO
                        </a>
                    </li>
                </ul>

                <div class="tab-content space-db--20" id="myTabContent">
                    <div class="tab-pane fade show active"
                         id="tab-1" role="tabpanel" aria-labelledby="tab1">
                        <article class="review-article">
                            <h1 class="sr-only">Product Description</h1>
                            <p>{!! $productDetails->description !!}</p>
                        </article>
                    </div>

                    <div class="tab-pane fade"
                         id="tab-2" role="tabpanel" aria-labelledby="tab2">
                        <article class="review-article">
                            <h1 class="sr-only">Additional Info</h1>
                            <!-- <p><strong>Material &amp; Care:</strong> {{ $productDetails->care }}</p>
                            <p><strong>Availability:</strong>
                                @if($total_stock>0) In Stock @else Out Of Stock @endif
                            </p> -->
                        </article>
                    </div>
                </div>
            </div>

            {{-- =========================
                 RELATED PRODUCTS (Pustok slider style)
               ========================== --}}
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <section class="">
                    <div class="container">
                        <div class="section-title section-title--bordered">
                            <h2>RELATED PRODUCTS</h2>
                        </div>

                        <div class="product-slider sb-slick-slider slider-border-single-row"
                             data-slick-setting='{
                                "autoplay": true,
                                "autoplaySpeed": 8000,
                                "slidesToShow": 4,
                                "dots": true
                             }'
                             data-slick-responsive='[
                                {"breakpoint":1200, "settings": {"slidesToShow": 4} },
                                {"breakpoint":992,  "settings": {"slidesToShow": 3} },
                                {"breakpoint":768,  "settings": {"slidesToShow": 2} },
                                {"breakpoint":480,  "settings": {"slidesToShow": 1} }
                             ]'>

                            @foreach($relatedProducts as $item)
                                @php
                                    $relName  = $item->product_name ?? 'Book';
                                    $relAuthor= $item->product_author ?? '';
                                    $relImg   = asset('images/backend_images/product/small/'.$item->image);
                                    $relUrl   = url('/product/'.$item->id); // same as your working route
                                    $relPrice = (float)($item->price ?? 0);
                                @endphp
                                <div class="single-slide">
                                    <div class="product-card">
                                        <div class="product-header">
                                            @if($relAuthor)
                                                <a href="javascript:void(0)" class="author">
                                                    {{ $relAuthor }}
                                                </a>
                                            @endif
                                            <h3>
                                                <a href="{{ $relUrl }}">{{ $relName }}</a>
                                            </h3>
                                        </div>
                                        <div class="product-card--body">
                                            <div class="card-image">
                                                <img src="{{ $relImg }}" alt="{{ $relName }}">
                                                <div class="hover-contents">
                                                    <a href="{{ $relUrl }}" class="hover-image">
                                                        <img src="{{ $relImg }}" alt="{{ $relName }}">
                                                    </a>
                                                    <div class="hover-btns">
                                                        {{-- keep theme hover basket as "go to product" so layout is identical --}}
                                                        <a href="{{ $relUrl }}" class="single-btn">
                                                            <i class="fas fa-shopping-basket"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="single-btn">
                                                            <i class="fas fa-heart"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="single-btn">
                                                            <i class="fas fa-random"></i>
                                                        </a>
                                                        <a href="#" data-bs-toggle="modal"
                                                           data-bs-target="#quickModal"
                                                           class="single-btn">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">
                                                    R {{ number_format($relPrice, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </section>
            @endif

            {{-- QUICK VIEW MODAL (left exactly as theme’s HTML) --}}
            <div class="modal fade modal-quick-view" id="quickModal" tabindex="-1" role="dialog"
                 aria-labelledby="quickModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="product-details-modal">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="product-details-slider sb-slick-slider arrow-type-two"
                                         data-slick-setting='{
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
                                                <a href="" class="btn btn-outlined--primary">
                                                    <span class="plus-icon">+</span>Add to Cart
                                                </a>
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

        </div> {{-- /.container --}}
    </main>

    {{-- BRAND SLIDER (unchanged from theme) --}}
    <section class="section-margin">
        <h2 class="sr-only">Brand Slider</h2>
        <div class="container">
            <div class="brand-slider sb-slick-slider border-top border-bottom"
                 data-slick-setting='{
                    "autoplay": true,
                    "autoplaySpeed": 8000,
                    "slidesToShow": 6
                 }'
                 data-slick-responsive='[
                    {"breakpoint":992, "settings": {"slidesToShow": 4} },
                    {"breakpoint":768, "settings": {"slidesToShow": 3} },
                    {"breakpoint":575, "settings": {"slidesToShow": 3} },
                    {"breakpoint":480, "settings": {"slidesToShow": 2} },
                    {"breakpoint":320, "settings": {"slidesToShow": 1} }
                 ]'>
                <div class="single-slide"><img src="image/others/brand-1.jpg" alt=""></div>
                <div class="single-slide"><img src="image/others/brand-2.jpg" alt=""></div>
                <div class="single-slide"><img src="image/others/brand-3.jpg" alt=""></div>
                <div class="single-slide"><img src="image/others/brand-4.jpg" alt=""></div>
                <div class="single-slide"><img src="image/others/brand-5.jpg" alt=""></div>
                <div class="single-slide"><img src="image/others/brand-6.jpg" alt=""></div>
                <div class="single-slide"><img src="image/others/brand-1.jpg" alt=""></div>
                <div class="single-slide"><img src="image/others/brand-2.jpg" alt=""></div>
            </div>
        </div>
    </section>

</div> {{-- /.site-wrapper --}}

{{-- Toast (same behaviour as your working version) --}}
<div id="toast" class="toast-message">🛒 Added to cart!</div>

<style>
    .toast-message{
        visibility:hidden;opacity:0;
        position:fixed;left:50%;bottom:40px;transform:translateX(-50%);
        background:#00a3c4;color:#fff;padding:12px 18px;border-radius:10px;
        box-shadow:0 10px 25px rgba(0,0,0,.15);z-index:9999;font-weight:600;
        transition:opacity .3s ease, bottom .3s ease, visibility 0s .3s
    }
    .toast-message.show{
        visibility:visible;opacity:1;bottom:60px;
        transition:opacity .3s ease,bottom .3s ease
    }
</style>

<script>
(function(){
    function showToast(msg){
        var t = document.getElementById('toast');
        if(!t) return;
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(function(){ t.classList.remove('show'); }, 2200);
    }

    var form = document.getElementById('addtoCartForm');
    if(!form) return;

    form.addEventListener('submit', function(e){
        e.preventDefault();

        // honour normal HTML5 validation (size required, etc.)
        if (!form.checkValidity()) {
            if (form.reportValidity) form.reportValidity();
            return;
        }

        var btn = document.getElementById('cartButton');
        if(btn) btn.disabled = true;

        var data = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: data
        })
        .then(function(r){
            return r.json().catch(function(){ return {}; });
        })
        .then(function(res){
            if(res && typeof res.cart_count !== 'undefined'){
                var cc = document.getElementById('cart-count');
                if(cc) cc.textContent = res.cart_count;
            }
            showToast('✅ Added to cart successfully!');
        })
        .catch(function(){
            showToast('❌ Error adding to cart.');
        })
        .finally(function(){
            if(btn) btn.disabled = false;
        });
    }, false);
})();
</script>
@endsection
