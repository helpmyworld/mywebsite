{{-- resources/views/index.blade.php --}}
@extends('layouts.frontLayout.front_design')

@section('title', 'Shop — Helpmyworld Publishing')

@section('content')
<div class="site-wrapper" id="top">
    {{-- ======= Header/Sticky header come from your layout; not duplicated here ======= --}}

    {{-- Breadcrumb (unchanged structure) --}}
    <section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Books</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- Main content: RIGHT SIDEBAR layout kept as in template --}}
    <main class="inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row">

                {{-- LEFT: Product grid (kept col-lg-9 as in HTML) --}}
                <div class="col-lg-9">
                    {{-- Toolbar (left as-is; only the numbers may remain static to match template) --}}
                    <div class="shop-toolbar with-sidebar mb--30">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-md-2 col-sm-6">
                                <div class="product-view-mode">
                                    <a href="#" class="sorting-btn active" data-target="grid"><i class="fas fa-th"></i></a>
                                    <a href="#" class="sorting-btn" data-target="grid-four">
                                        <span class="grid-four-icon">
                                            <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                                        </span>
                                    </a>
                                    <a href="#" class="sorting-btn" data-target="list "><i class="fas fa-list"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-6  mt--10 mt-sm--0">
                                {{-- Keep template text to preserve layout --}}
                                <span class="toolbar-status">
                                    Showing 1 to 9 of 14 (2 Pages)
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6  mt--10 mt-md--0">
                                <div class="sorting-selection">
                                    <span>Show:</span>
                                    <select class="form-control nice-select sort-select">
                                        <option value="" selected="selected">3</option>
                                        <option value="">9</option>
                                        <option value="">5</option>
                                        <option value="">10</option>
                                        <option value="">12</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 mt--10 mt-md--0 ">
                                <div class="sorting-selection">
                                    <span>Sort By:</span>
                                    <select class="form-control nice-select sort-select mr-0">
                                        <option value="" selected="selected">Default Sorting</option>
                                        <option value="">Sort By:Name (A - Z)</option>
                                        <option value="">Sort By:Name (Z - A)</option>
                                        <option value="">Sort By:Price (Low &gt; High)</option>
                                        <option value="">Sort By:Price (High &gt; Low)</option>
                                        <option value="">Sort By:Rating (Highest)</option>
                                        <option value="">Sort By:Rating (Lowest)</option>
                                        <option value="">Sort By:Model (A - Z)</option>
                                        <option value="">Sort By:Model (Z - A)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden toolbar variant from template (kept as-is, display none) --}}
                    <div class="shop-toolbar d-none">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-md-2 col-sm-6">
                                <div class="product-view-mode">
                                    <a href="#" class="sorting-btn active" data-bs-target="grid"><i class="fas fa-th"></i></a>
                                    <a href="#" class="sorting-btn" data-bs-target="grid-four">
                                        <span class="grid-four-icon">
                                            <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                                        </span>
                                    </a>
                                    <a href="#" class="sorting-btn" data-bs-target="list "><i class="fas fa-list"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-5 col-md-4 col-sm-6  mt--10 mt-sm--0">
                                <span class="toolbar-status">
                                    Showing 1 to 9 of 14 (2 Pages)
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6  mt--10 mt-md--0">
                                <div class="sorting-selection">
                                    <span>Show:</span>
                                    <select class="form-control nice-select sort-select">
                                        <option value="" selected="selected">3</option>
                                        <option value="">9</option>
                                        <option value="">5</option>
                                        <option value="">10</option>
                                        <option value="">12</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mt--10 mt-md--0 ">
                                <div class="sorting-selection">
                                    <span>Sort By:</span>
                                    <select class="form-control nice-select sort-select mr-0">
                                        <option value="" selected="selected">Default Sorting</option>
                                        <option value="">Sort By:Name (A - Z)</option>
                                        <option value="">Sort By:Name (Z - A)</option>
                                        <option value="">Sort By:Price (Low &gt; High)</option>
                                        <option value="">Sort By:Price (High &gt; Low)</option>
                                        <option value="">Sort By:Rating (Highest)</option>
                                        <option value="">Sort By:Rating (Lowest)</option>
                                        <option value="">Sort By:Model (A - Z)</option>
                                        <option value="">Sort By:Model (Z - A)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PRODUCT GRID — exact wrappers/classes preserved; only card internals are bound to data --}}
                    <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">

                        @php
                            // Use your existing variable names without changing logic:
                            // Prefer $books (bookshop view), else $products.
                            $items = isset($books) ? $books : (isset($products) ? $products : collect());
                        @endphp

                        @foreach($items as $item)
                            @php
                                $title   = $item->title ?? $item->name ?? $item->product_name ?? 'Book';
                                $author  = $item->author_name ?? $item->product_author ?? '';
                                $slug    = $item->slug ?? $item->id;
                                $url     = url('/product/'.$slug);

                                // Image paths (match your project’s structure)
                                $imgMain  = !empty($item->image)
                                            ? asset('images/backend_images/product/small/'.$item->image)
                                            : asset('images/no-image.png');
                                $imgHover = !empty($item->hover_image)
                                            ? asset('images/backend_images/product/small/'.$item->hover_image)
                                            : $imgMain;

                                // Pricing (keep template price blocks)
                                $price    = isset($item->price) ? (float)$item->price : null;
                                $oldPrice = isset($item->old_price) ? (float)$item->old_price : null;
                                $discPct  = ($price && $oldPrice && $oldPrice > $price)
                                            ? round(100 * (1 - ($price / $oldPrice)))
                                            : null;

                                // Add-to-cart payload pieces (non-destructive; use if present)
                                $pid   = $item->id ?? $item->product_id ?? null;
                                $code  = $item->product_code ?? '';
                                $color = $item->product_color ?? '';
                                $ptype = $item->type ?? $item->product_type ?? '';
                            @endphp

                            <div class="col-lg-4 col-sm-6">
                                <div class="product-card">

                                    {{-- GRID CARD (kept exactly) --}}
                                    <div class="product-grid-content">
                                        <div class="product-header">
                                            @if($author)
                                                <a href="" class="author">{{ $author }}</a>
                                            @endif
                                            <h3><a href="{{ $url }}">{{ $title }}</a></h3>
                                        </div>
                                        <div class="product-card--body">
                                            <div class="card-image">
                                                <img src="{{ $imgMain }}" alt="{{ $title }}" onerror="this.src='{{ asset('images/no-image.png') }}'">
                                                <div class="hover-contents">
                                                    <a href="{{ $url }}" class="hover-image">
                                                        <img src="{{ $imgHover }}" alt="{{ $title }}" onerror="this.src='{{ asset('images/no-image.png') }}'">
                                                    </a>
                                                    <div class="hover-btns">
                                                        {{-- BASKET ICON NOW DOES AJAX ADD-TO-CART --}}
                                                        <a href="javascript:void(0)"
                                                           class="single-btn add-to-cart"
                                                           data-id="{{ $pid }}"
                                                           data-name="{{ $title }}"
                                                           data-code="{{ $code }}"
                                                           data-color="{{ $color }}"
                                                           data-price="{{ $price }}"
                                                           data-type="{{ $ptype }}">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </a>

                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-block">
                                                @if(!is_null($price))
                                                    <span class="price">R {{ number_format($price,2) }}</span>
                                                @endif
                                                @if(!is_null($oldPrice) && $oldPrice > $price)
                                                    <del class="price-old">R {{ number_format($oldPrice,2) }}</del>
                                                @endif
                                                @if(!is_null($discPct))
                                                    <span class="price-discount">{{ $discPct }}%</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- LIST CARD (kept exactly) --}}
                                    <div class="product-list-content">
                                        <div class="card-image">
                                            <img src="{{ $imgMain }}" alt="{{ $title }}" onerror="this.src='{{ asset('images/no-image.png') }}'">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                @if($author)
                                                    <a href="" class="author">{{ $author }}</a>
                                                @endif
                                                <h3><a href="{{ $url }}" tabindex="0">{{ $title }}</a></h3>
                                            </div>
                                            <article>
                                                <h2 class="sr-only"></h2>
                                                {{-- Keep template placeholder text; do not invent content --}}
                                                <p></p>
                                            </article>
                                            <div class="price-block">
                                                @if(!is_null($price))
                                                    <span class="price">R {{ number_format($price,2) }}</span>
                                                @endif
                                                @if(!is_null($oldPrice) && $oldPrice > $price)
                                                    <del class="price-old">R {{ number_format($oldPrice,2) }}</del>
                                                @endif
                                                @if(!is_null($discPct))
                                                    <span class="price-discount">{{ $discPct }}%</span>
                                                @endif
                                            </div>
                                            <div class="rating-block">
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star "></span>
                                            </div>
                                            <div class="btn-block">
                                                {{-- Same look, now AJAX add-to-cart --}}
                                                <button type="button"
                                                    class="btn btn-outlined add-to-cart"
                                                    data-id="{{ $pid }}"
                                                    data-name="{{ $title }}"
                                                    data-code="{{ $code }}"
                                                    data-color="{{ $color }}"
                                                    data-price="{{ $price }}"
                                                    data-type="{{ $ptype }}">
                                                    Add To Cart
                                                </button>
                                                
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- Pagination Block (markup kept exactly; if your old Blade rendered links, keep that logic elsewhere) --}}
                    <div class="row pt--30">
                        <div class="col-md-12">
                            <div class="pagination-block">
                                <ul class="pagination-btns flex-center">
                                    <li><a href="" class="single-btn prev-btn ">|<i class="zmdi zmdi-chevron-left"></i> </a></li>
                                    <li><a href="" class="single-btn prev-btn "><i class="zmdi zmdi-chevron-left"></i> </a></li>
                                    <li class="active"><a href="" class="single-btn">1</a></li>
                                    <li><a href="" class="single-btn">2</a></li>
                                    <li><a href="" class="single-btn">3</a></li>
                                    <li><a href="" class="single-btn">4</a></li>
                                    <li><a href="" class="single-btn next-btn"><i class="zmdi zmdi-chevron-right"></i></a></li>
                                    <li><a href="" class="single-btn next-btn"><i class="zmdi zmdi-chevron-right"></i>|</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Quick View Modal (kept exactly; images left as in template) --}}
                    <div class="modal fade modal-quick-view" id="quickModal" tabindex="-1" role="dialog"
                         aria-labelledby="quickModal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                <div class="product-details-modal">
                                    <div class="row">
                                        <div class="col-lg-5">
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
                                                    <p>Long printed dress with thin adjustable straps. V-neckline and wiring under the Dust with ruffles at the bottom of the dress.</p>
                                                </article>
                                                <div class="add-to-cart-row">
                                                    <div class="count-input-block">
                                                        <span class="widget-label">Qty</span>
                                                        <input type="number" class="form-control text-center" value="1">
                                                    </div>
                                                    <div class="add-cart-btn">
                                                        <a href="" class="btn btn-outlined--primary"><span class="plus-icon">+</span>Add to Cart</a>
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
                    </div>{{-- /#quickModal --}}

                </div>{{-- /.col-lg-9 --}}

                {{-- RIGHT: Sidebar (now pulls categories via your original include) --}}
                
                <div class="col-lg-3 mt--40 mt-lg--0">
                    <div class="inner-page-sidebar">
                      @include('layouts.frontLayout.front_sidebar')
                    </div>
                  </div>

            </div>
        </div>
    </main>
</div>

{{-- Brand slider section from template (left intact) --}}
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

    
        <!-- Toast -->
        <div id="toast" class="toast-message">🛒 Added to cart!</div>

        <!-- Minimal styles for toast (no theme layout changes) -->
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

        <!-- Vanilla JS add-to-cart (no alert; shows toast). Layout/theme untouched. -->
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
                data.append('product_id',  btn.dataset.id || '');
                data.append('product_name',btn.dataset.name || '');
                data.append('product_code',btn.dataset.code || '');
                data.append('product_color',btn.dataset.color || '');
                data.append('price',       btn.dataset.price || '');
                data.append('product_type',btn.dataset.type || '');
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
                .catch(function(){
                    showToast('❌ Error adding to cart.');
                })
                .finally(function(){ btn.disabled=false; });
            }, false);
        })();
        </script>
</section>
@endsection
