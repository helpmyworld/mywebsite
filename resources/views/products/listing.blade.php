@extends('layouts.frontLayout.front_design')

@section('content')

{{-- Breadcrumb (theme style) --}}
<section class="breadcrumb-section">
  <h2 class="sr-only">Site Breadcrumb</h2>
  <div class="container">
    <div class="breadcrumb-contents">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Shop</li>
        </ol>
      </nav>
    </div>
  </div>
</section>

<main class="inner-page-sec-padding-bottom">
  <div class="container">
    <div class="row">

      {{-- MAIN: Product listing (theme 9-col) --}}
      <div class="col-lg-9">

        {{-- Toolbar (visual only; your logic untouched) --}}
        <div class="shop-toolbar with-sidebar mb--30">
          <div class="row align-items-center">
            <div class="col-lg-2 col-md-2 col-sm-6">
              <div class="product-view-mode">
                <a href="javascript:void(0)" class="sorting-btn" data-target="grid"><i class="fas fa-th"></i></a>
                <a href="javascript:void(0)" class="sorting-btn" data-target="grid-four">
                  <span class="grid-four-icon"><i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i></span>
                </a>
                <a href="javascript:void(0)" class="sorting-btn active" data-target="list"><i class="fas fa-list"></i></a>
              </div>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-6 mt--10 mt-sm--0">
              <h2 class="mb-0 h5">
                @if(!empty($search_product))
                  {{ $search_product }} Item
                @else
                  {{ $categoryDetails->name }} Items
                @endif
              </h2>
            </div>
          </div>
        </div>

        {{-- Theme list wrapper (style only) --}}
        <div class="shop-product-wrap list with-pagination row space-db--30 shop-border">

          {{-- ==== YOUR EXISTING LOOP & FIELDS (unchanged) ==== --}}
          @foreach($productsAll as $pro)
            @php
              $url  = url('/product/'.$pro->slug);
              $img  = asset('/images/backend_images/product/small/'.$pro->image);
              $name = $pro->product_name;
              $price = $pro->price;
            @endphp

            <div class="col-lg-12">
              <div class="product-card card-style-list">

                {{-- LIST face (theme) --}}
                <div class="product-list-content">
                  <div class="card-image">
                    <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $name }}"></a>
                  </div>
                  <div class="product-card--body">
                    <div class="product-header">
                      <h3><a href="{{ $url }}">{{ $name }}</a></h3>
                    </div>

                    <div class="price-block">
                      <span class="price">R {{ number_format($price, 2) }}</span>
                    </div>

                    <div class="btn-block">
                      {{-- Keep your original behavior: link to product page --}}
                      <a href="{{ $url }}" class="btn btn-outlined">
                        <i class="fa fa-shopping-cart"></i> Add to cart
                      </a>
                    </div>
                  </div>
                </div>

                {{-- GRID face kept for theme scripts (not used by your logic) --}}
                <div class="product-grid-content d-none">
                  <div class="product-header">
                    <h3><a href="{{ $url }}">{{ $name }}</a></h3>
                  </div>
                  <div class="product-card--body">
                    <div class="card-image">
                      <a href="{{ $url }}"><img src="{{ $img }}" alt="{{ $name }}"></a>
                    </div>
                    <div class="price-block">
                      <span class="price">R {{ number_format($price, 2) }}</span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          @endforeach
          {{-- ================================================ --}}

        </div><!-- /.shop-product-wrap -->
      </div><!-- /.col-lg-9 -->

      {{-- SIDEBAR: (your include, as requested) --}}
      <div class="col-lg-3 mt--40 mt-lg--0">
        <div class="inner-page-sidebar">
          @include('layouts.frontLayout.front_sidebar')
        </div>
      </div>

    </div>
  </div>
</main>

@endsection
