@extends('layouts.frontLayout.front_design')

@section('title', $user->name)

@push('styles')
<style>
  .author-wrapper {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .author-header {
    background-color: #f8f9fa;
    padding: 60px 0 40px;
    border-bottom: 1px solid #eee;
    width: 100%;
  }

  .author-header img {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
  }

  .author-header h2 {
    margin-top: 15px;
    color: #305893;
  }

  .author-header .social-links a {
    color: #305893;
    margin: 0 8px;
    font-size: 18px;
    transition: 0.3s ease;
  }

  .author-header .social-links a:hover {
    color: #27497a;
  }

  .author-bio {
    margin: 40px auto;
    max-width: 800px;
    font-size: 15px;
    line-height: 1.8;
    color: #333;
  }

  .centered-section {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .product-grid {
    justify-content: center;
  }

  .product-grid .card {
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    transition: all .3s;
    width: 100%;
    max-width: 320px;
    margin: 0 auto;
  }

  .product-grid .card:hover {
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
  }

  .product-grid .card-body {
    padding: 15px;
    text-align: center;
  }

  .product-grid img {
    width: 100%;
    height: 240px;
    object-fit: cover;
  }

  .section-title {
    text-align: center;
    font-weight: 600;
    margin: 50px 0 30px;
    color: #305893;
  }

  .btn-primary {
    background-color: #305893;
    border-color: #305893;
  }

  .btn-primary:hover {
    background-color: #27497a;
    border-color: #27497a;
  }
</style>
@endpush

@section('content')


<!-- Breadcrumb -->
<section class="breadcrumb-section">
  <h2 class="sr-only">Site Breadcrumb</h2>
  <div class="container">
    <div class="breadcrumb-contents">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Author Profile</li>
        </ol>
      </nav>
    </div>
  </div>
</section>


    

<div class="author-wrapper" style="center">
  <div class="author-header text-center d-flex flex-column align-items-center justify-content-center">
    @php
      $filename = $user->profile_image ?? $user->image ?? null;
      $profileImg = asset('images/users/default.png');
      if ($filename) {
          $newPath = 'images/backend_images/authors/medium/'.$filename;
          $oldPath = 'uploads/profile/'.$filename;
          if (file_exists(public_path($newPath))) {
              $profileImg = asset($newPath);
          } elseif (file_exists(public_path($oldPath))) {
              $profileImg = asset($oldPath);
          }
      }
    @endphp

    <img src="{{ $profileImg }}" alt="{{ $user->name }}" class="author-image mb-3">
    <h2 class="author-name mb-1">{{ $user->name }}</h2>

    @if($user->country)
      <p class="text-muted mb-2">{{ $user->country }}</p>
    @endif

    <div class="social-links mt-2">
      @if($user->facebook)
        <a href="{{ $user->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>
      @endif
      @if($user->twitter)
        <a href="{{ $user->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a>
      @endif
      @if($user->linkln)
        <a href="{{ $user->linkln }}" target="_blank"><i class="fa fa-linkedin"></i></a>
      @endif
    </div>
</div>


  <div class="container centered-section">
    <div class="author-bio">
      {!! $user->bio !!}
    </div>
    <br><br>

    <!-- Physical Books -->
    <h3 class="section-title">Books by {{ $user->name }}</h3>
    <div class="row product-grid">
      @forelse($user->products()->where('type','Physical Book')->where('approved',true)->get() as $pro)
        <div class="col-md-4 mb-4 d-flex justify-content-center">
          <div class="card">
            <a href="{{ url('/product/'.$pro->slug) }}">
              <img src="{{ asset('/images/backend_images/product/small/'.$pro->image) }}" alt="{{ $pro->product_name }}">
            </a>
            <div class="card-body">
              <h5 class="card-title">{{ $pro->product_name }}</h5>
              <p class="text-muted mb-1">R {{ number_format($pro->price, 2) }}</p>
              <a href="{{ url('/product/'.$pro->slug) }}" class="btn btn-primary btn-sm mt-2">
                <i class="fa fa-shopping-cart"></i> Add to Cart
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center text-muted mb-5">No physical books available.</div>
      @endforelse
    </div>
    <br><br>

    <!-- eBooks -->
    <h3 class="section-title">E-Books by {{ $user->name }}</h3>
    <div class="row product-grid">
      @forelse($user->products()->where('type','ebook')->where('approved',true)->get() as $pro)
        <div class="col-md-4 mb-4 d-flex justify-content-center">
          <div class="card">
            <a href="{{ url('/product/'.$pro->slug) }}">
              <img src="{{ asset('/images/backend_images/product/small/'.$pro->image) }}" alt="{{ $pro->product_name }}">
            </a>
            <div class="card-body">
              <h5 class="card-title">{{ $pro->product_name }}</h5>
              <p class="text-muted mb-1">R {{ number_format($pro->price, 2) }}</p>
              <a href="{{ url('/product/'.$pro->slug) }}" class="btn btn-primary btn-sm mt-2">
                <i class="fa fa-shopping-cart"></i> Add to Cart
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center text-muted mb-5">No eBooks available.</div>
      @endforelse
    </div>
  </div>
</div>

@endsection
