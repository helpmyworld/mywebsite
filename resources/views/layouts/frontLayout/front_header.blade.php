<div class="site-header header-2 mb--20 d-none d-lg-block">
            <div class="header-middle pt--10 pb--10">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                           
                            <a href="{{ url('./')}}" class="site-brand"><img src="{{ asset('/images/frontend_images/banners/logo.png') }}" alt="" /></a>
                        </div>
                        <div class="col-lg-5">
                            <div class="header-search-block">
                                <form action="{{ url('/search-products') }}" method="post">{{ csrf_field() }}
                                <input type="text" placeholder="Search Product" name="product" />
                                <button type="submit" >Search</button>
                            </form>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="main-navigation flex-lg-right">
                                <div class="cart-widget">
                                    <div class="login-block">
                                        @if(empty(Auth::check()))
                                        <a href="{{ url('/login-register') }}" class="font-weight-bold">Login</a> <br>
                                        <span>or</span><a href="{{ url('/login-register') }}">Register</a>
                                        @else
                                            @if(auth()->user()->type == "Author")
                                                <li><a href="{{route('author.dashboard')}}"><i class="fa fa-user"></i> Account</a></li>
                                                @else
                                                <li><a href="{{ url('/account') }}"><i class="fa fa-user"></i> Account</a></li>
                                                @endif

                                            <li><a href="{{ url('/user-logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
                                        @endif

                                    </div>


                                    @php
    // Pull from your session (fallbacks included)
    $cartItems = session('cart', []); // expect array of items: ['id','slug','image','product_name','price','quantity',...]
    $cartCount = session('cart_count', is_array($cartItems) ? collect($cartItems)->sum('quantity') : 0);
    $cartTotal = session('cart_total', is_array($cartItems)
        ? collect($cartItems)->reduce(function($t, $i){
            $qty = isset($i['quantity']) ? (int)$i['quantity'] : 1;
            $price = isset($i['price']) ? (float)$i['price'] : 0;
            return $t + ($qty * $price);
        }, 0)
        : 0
    );
@endphp

<div class="cart-block">
    <div class="cart-total">
        <span class="text-number">{{ $cartCount }}</span>
        <span class="text-item">Shopping Cart</span>
        <span class="price">
            R {{ number_format($cartTotal, 2) }}
            <i class="fas fa-chevron-down"></i>
        </span>
    </div>

    <div class="cart-dropdown-block">
        {{-- List a few items --}}
        @if(is_array($cartItems) && count($cartItems))
            @foreach(collect($cartItems)->take(3) as $item)
                @php
                    $slug  = $item['slug'] ?? ($item['id'] ?? '');
                    $url   = url('/product/'.$slug);
                    $img   = asset('/images/backend_images/product/small/'.($item['image'] ?? ''));
                    $name  = $item['product_name'] ?? 'Item';
                    $qty   = isset($item['quantity']) ? (int)$item['quantity'] : 1;
                    $price = isset($item['price']) ? (float)$item['price'] : 0;
                @endphp

                <div class="single-cart-block">
                    <div class="cart-product">
                        <a href="{{ $url }}" class="image">
                            <img src="{{ $img }}" alt="{{ $name }}">
                        </a>
                        <div class="content">
                            <h3 class="title"><a href="{{ $url }}">{{ $name }}</a></h3>
                            <p class="price"><span class="qty">{{ $qty }} ×</span> R {{ number_format($price, 2) }}</p>

                            {{-- If you have a remove route, swap href below to that. Otherwise just send them to /cart --}}
                            <a href="{{ url('/cart') }}" class="cross-btn"><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="single-cart-block">
                <div class="cart-product">
                    <div class="content">
                        <p class="mb-0">Your cart is empty.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Actions --}}
        <div class="single-cart-block">
            <div class="btn-block">
                <a href="{{ url('/cart') }}" class="btn">View Cart <i class="fas fa-chevron-right"></i></a>
                <a href="{{ url('/checkout') }}" class="btn btn--primary">Check Out <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </div>
</div>






                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          <!--================================= //CATEGORY  ===================================== -->
            <div class="header-bottom bg-primary">
                <div class="container">
                    <div class="row align-items-center">
<div class="col-lg-3">
<nav class="category-nav white-nav">
  <div>
    <a href="javascript:void(0)" class="category-trigger">
      <i class="fa fa-bars"></i>Browse categories
    </a>

    @if(isset($categories) && $categories->count())
      <ul class="category-menu">
        @foreach($categories as $cat)
          @if((isset($cat->status) ? $cat->status : 1) == 1)
            <li class="cat-item">
              <a href="{{ url('products/' . ($cat->url ?? $cat->slug ?? $cat->id)) }}">
                {{ $cat->name }}
              </a>
            </li>
          @endif
        @endforeach
      </ul>
    @endif
  </div>
</nav>
</div>

                        <div class="col-lg-3">
                            <div class="header-phone color-white">
                                <div class="icon">
                                    <i class="fas fa-headphones-alt"></i>
                                </div>
                                <div class="text">
                                    <p class="font-weight-bold number">081 022  7831  &nbsp | &nbsp info@helpmyworld.co.za</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="main-navigation flex-lg-right">
                                <ul class="main-menu menu-right main-menu--white li-last-0">
                                    <li class="menu-item has-children">
                                        <a href="{{ url('./')}}">Home </a>
                                    </li>
                                    <!-- Shop -->
                                    <li class="menu-item has-children mega-menu">
                                        <a href="{{url ('books')}}">For Readers   </a>
                                    </li>
                                    <!-- Pages -->
                                    <li class="menu-item has-children">
                                        <a href="{{route('services')}}">For Authors </a>
                                    </li>
                                    <!-- Blog -->
                                    <li class="menu-item has-children mega-menu">
                                        <a href="{{ url('about')}}">About </a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <!--================================= //MOBILE  ===================================== -->
        <div class="site-mobile-menu">
            <header class="mobile-header d-block d-lg-none pt--10 pb-md--10">
                <div class="container">
                    <div class="row align-items-sm-end align-items-center">
                        <div class="col-md-4 col-7">
                            <a href="{{ url('./')}}" class="site-brand"><img src="{{ asset('/images/frontend_images/banners/logo.png') }}" alt="" /></a>
                        </div>
                        <div class="col-md-5 order-3 order-md-2">
                            <nav class="category-nav   ">
                                <div>
                                    <a href="javascript:void(0)" class="category-trigger">
                                      <i class="fa fa-bars"></i>Browse categories
                                    </a>

                                    @if(isset($categories) && $categories->count())
                                      <ul class="category-menu">
                                        @foreach($categories as $cat)
                                          @if((isset($cat->status) ? $cat->status : 1) == 1)
                                            <li class="cat-item">
                                              <a href="{{ url('products/' . ($cat->url ?? $cat->slug ?? $cat->id)) }}">
                                                {{ $cat->name }}
                                              </a>
                                            </li>
                                          @endif
                                        @endforeach
                                      </ul>
                                    @endif
                                </div>
                            </nav>
                        </div>
                        <div class="col-md-3 col-5  order-md-3 text-right">
                            <div class="mobile-header-btns header-top-widget">
                                <ul class="header-links">
                                    <li class="sin-link">
                                        <a href="{{ url('/cart') }}" class="cart-link link-icon"><i class="ion-bag"></i></a>

                                    </li>
                                    <li class="sin-link">
                                        <a href="javascript:" class="link-icon hamburgur-icon off-canvas-btn"><i
                                                class="ion-navicon"></i></a>
                                    </li>


                                </ul>
                            </div>
                        </div>

                        <div class="col-md-3 col-5 order-md-3 text-right">
    <div class="mobile-header-btns header-top-widget">
        <ul class="header-links">
            <li class="sin-link">
                <a href="{{ url('/orders') }}" class="link-icon"><i class="ion-ios-list"></i></a>
            </li>
            <li class="sin-link">
                <a href="{{ url('/cart') }}" class="cart-link link-icon"><i class="ion-bag"></i></a>
            </li>

            @if(empty(Auth::check()))
                <li class="sin-link">
                    <a href="{{ url('/login-register') }}" class="link-icon"><i class="ion-log-in"></i></a>
                </li>
            @else
                @if(auth()->user()->type == "Author")
                    <li class="sin-link">
                        <a href="{{ route('author.dashboard') }}" class="link-icon"><i class="ion-person"></i></a>
                    </li>
                @else
                    <li class="sin-link">
                        <a href="{{ url('/account') }}" class="link-icon"><i class="ion-person"></i></a>
                    </li>
                @endif
                <li class="sin-link">
                    <a href="{{ url('/user-logout') }}" class="link-icon"><i class="ion-log-out"></i></a>
                </li>
            @endif

            <li class="sin-link">
                <a href="javascript:" class="link-icon hamburgur-icon off-canvas-btn"><i class="ion-navicon"></i></a>
            </li>
        </ul>
    </div>
</div>







                    </div>
                </div>
            </header>
            <!--Off Canvas Navigation Start-->
            <aside class="off-canvas-wrapper">
                <div class="btn-close-off-canvas">
                    <i class="ion-android-close"></i>
                </div>
                <div class="off-canvas-inner">
                    <!-- search box start -->
                    <div class="search-box offcanvas">
                        <form action="{{ url('/search-products') }}" method="post">{{ csrf_field() }}
                                <input type="text" placeholder="Search Product" name="product" />
                                <button type="submit" >Search</button>
                            </form>
                    </div>
                    <!-- search box end -->
                    <!-- mobile menu start -->
                    <div class="mobile-navigation">
                        <!-- mobile menu navigation start -->
                        <nav class="off-canvas-nav">
                            <ul class="mobile-menu main-mobile-menu">
                                <li class="menu-item-has-children">
                                    <a href="{{ url('./')}}">Home</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="{{url ('books')}}">For Readers  </a>
                                </li>
                                <li class="menu-item-has-children">
                                        <a href="{{route('services')}}">For Authors </a>
                                </li> 
                                <li class="menu-item-has-children">
                                    <a href="{{route('about')}}">About </a>
                                </li>
                                
                            </ul>
                        </nav>
                        <!-- mobile menu navigation end -->
                    </div>
                    <!-- mobile menu end -->


                    <nav class="off-canvas-nav">
                        <ul class="mobile-menu menu-block-2">
                            <li class="menu-item-has-children">
                                <a href="#">Currency - R <i class="fas fa-angle-down"></i></a>
                                
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Lang - Eng<i class="fas fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                    <li>Eng</li>
                                   
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">My Account <i class="fas fa-angle-down"></i></a>
                                <ul class="sub-menu">

                                    @if(empty(Auth::check()))
                                        <a href="{{ url('/login-register') }}" class="font-weight-bold">Login</a> <br>
                                        <span>or</span><a href="{{ url('/login-register') }}">Register</a>
                                        @else
                                            @if(auth()->user()->type == "Author")
                                                <li><a href="{{route('author.dashboard')}}"><i class="fa fa-user"></i> Account</a></li>
                                                @else
                                                <li><a href="{{ url('/account') }}"><i class="fa fa-user"></i> Account</a></li>
                                                @endif

                                            <li><a href="{{ url('/user-logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
                                        @endif

                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <div class="off-canvas-bottom">
                        <div class="contact-list mb--10">
                            <a href="" class="sin-contact"><i class="fas fa-mobile-alt"></i>081 022 7831</a>
                            <a href="" class="sin-contact"><i class="fas fa-envelope"></i>info@helpmyworld.co.za</a>
                        </div>
                        <div class="off-canvas-social">
                            <a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="single-icon"><i class="fas fa-rss"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </aside>
            <!--Off Canvas Navigation End-->
        </div>

        <!--================================= //MENU  ===================================== -->
        <div class="sticky-init fixed-header common-sticky">
            <div class="container d-none d-lg-block">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <a href="index.html" class="site-brand">
                           <a href="{{ url('./')}}" class="site-brand"><img src="{{ asset('/images/frontend_images/banners/logo.png') }}" alt="" /></a>
                        </a>
                    </div>
                    <div class="col-lg-8">
                        <div class="main-navigation flex-lg-right">
                            <ul class="main-menu menu-right ">
                                <li class="menu-item has-children">
                                    <a href="{{ url('./')}}">Home </a>
                                </li>
                                    <!-- Shop -->
                                    <li class="menu-item has-children mega-menu">
                                        <a href="{{url ('books')}}">For Readers  </a>
                                    </li>
                                     <li class="menu-item has-children mega-menu">
                                        <a href="{{route('services')}}">For Authors </a>
                                    </li>
                                    <!-- Pages -->
                                    <li class="menu-item has-children">
                                        <a href="{{route('about')}}">About </a>

                                    </li>
                                    <!-- Blog -->
                                   
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
