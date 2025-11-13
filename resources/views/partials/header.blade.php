@php
  use Illuminate\Support\Facades\Route;

  // Safe route fallbacks so nothing crashes if a named route doesn't exist yet
  $productsIndex  = Route::has('products.index')  ? route('products.index')  : url('/products');
  $cartIndex      = Route::has('cart.index')      ? route('cart.index')      : url('/cart');
  $checkoutIndex  = Route::has('checkout.index')  ? route('checkout.index')  : url('/checkout');
  $categoriesIndex= Route::has('categories.index')? route('categories.index'): url('/categories');
  $wishlistIndex  = Route::has('wishlist.index')  ? route('wishlist.index')  : url('/wishlist');
  $accountIndex   = Route::has('account.index')   ? route('account.index')   : url('/account');
  $loginUrl       = Route::has('login')           ? route('login')           : url('/login');

  // Provide safe defaults for header data if controller didn’t pass them
  $headerCategories  = $headerCategories  ?? \App\Category::orderBy('name')->take(10)->get();
  $cartCount         = $cartCount         ?? 0;
  $cartTotal         = $cartTotal         ?? 0;
@endphp

<header class="bw-header border-bottom">
  <div class="container-xl d-flex align-items-center justify-content-between py-2">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('bookworm/images/logo.svg') }}" alt="Bookworm" height="28" class="me-2">
      <span class="fw-bold d-none d-md-inline">{{ config('app.name', 'BOOKWORM') }}</span>
    </a>

    {{-- Desktop search --}}
    <form action="{{ Route::has('search') ? route('search') : url('/search') }}" method="GET" class="d-none d-lg-flex flex-grow-1 mx-3">
      <div class="input-group">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
          All Categories
        </button>
        <ul class="dropdown-menu">
          @foreach($headerCategories as $cat)
            <li>
              <a class="dropdown-item"
                 href="{{ Route::has('categories.show') ? route('categories.show', $cat->slug) : url('/categories/'.$cat->slug) }}">
                {{ $cat->name }}
              </a>
            </li>
          @endforeach
        </ul>
        <input type="text" name="q" class="form-control" placeholder="Search for books by keyword" value="{{ request('q') }}">
        <button class="btn btn-dark" type="submit">
          {{-- fallback icon if bootstrap-icons not included --}}
          <span class="d-inline-block" style="width:1rem;height:1rem;border-radius:50%;border:2px solid currentColor;border-left-color:transparent;display:inline-block;"></span>
        </button>
      </div>
    </form>

    {{-- Icons --}}
    <div class="d-flex align-items-center gap-3">
      <a href="{{ $wishlistIndex }}" class="text-decoration-none" title="Wishlist">♡</a>
      @auth
        <a href="{{ $accountIndex }}" class="text-decoration-none" title="Account">👤</a>
      @else
        <a href="{{ $loginUrl }}" class="text-decoration-none" title="Login">👤</a>
      @endauth
      <a href="{{ $cartIndex }}" class="text-decoration-none position-relative" title="Cart">
        🛍️
        @if($cartCount > 0)
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
            {{ $cartCount }}
          </span>
        @endif
      </a>
      <span class="fw-semibold">${{ number_format((float)$cartTotal, 2) }}</span>
    </div>
  </div>

  {{-- Main nav --}}
  <nav class="navbar navbar-expand-lg">
    <div class="container-xl">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bwMainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="bwMainNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ $categoriesIndex }}">Categories</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Shop</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ $productsIndex }}">All Products</a></li>
              <li><a class="dropdown-item" href="{{ $cartIndex }}">Cart</a></li>
              <li><a class="dropdown-item" href="{{ $checkoutIndex }}">Checkout</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/blog') }}">Blog</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>
