@extends('layouts.frontLayout.front_design')

@push('styles')
<style>
  /* Minimal extras to make author avatars round and tidy within the theme card */
  .author-avatar {
    width: 120px; height: 120px; border-radius: 50%;
    object-fit: cover; display: inline-block;
  }
  .author-card .card-body { padding-top: 24px; }
  .author-name { color:#305893; }
  .author-search .form-control { height: 48px; }
</style>
@endpush

@section('content')

  {{-- Breadcrumb (theme style) --}}
  <section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
      <div class="breadcrumb-contents">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Authors</li>
          </ol>
        </nav>
      </div>
    </div>
  </section>

  {{-- Page body --}}
  <main class="inner-page-sec-padding-bottom">
    <div class="container">

      {{-- Title row --}}
      <div class="row align-items-center mb--20">
        <div class="col">
          <h2 class="mb-0">Authors</h2>
        </div>
      </div>

      {{-- Search --}}
      <div class="row mb--20">
        <div class="col-12">
          <form class="author-search" method="GET" action="{{ route('author.filter') }}">
            <div class="row g-2">
              <div class="col-sm-9 col-md-10">
                <input type="text" class="form-control" name="name" placeholder="Search by name" required>
              </div>
              <div class="col-sm-3 col-md-2 d-grid">
                <button class="btn btn--primary">Search</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      {{-- Authors grid (using shop/product grid wrappers from theme) --}}
      <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">
  @if(count($authors) > 0)
    @foreach($authors as $row)
      @php
        // Prefer new field, fall back to legacy
        $filename = $row->profile_image ?? $row->image ?? null;

        // Default avatar first
        $img = asset('images/users/default.png');

        if ($filename) {
            $newPathRel = 'images/backend_images/authors/medium/'.$filename; // new storage
            $oldPathRel = 'uploads/profile/'.$filename;                      // legacy storage

            if (file_exists(public_path($newPathRel))) {
                $img = asset($newPathRel);
            } elseif (file_exists(public_path($oldPathRel))) {
                $img = asset($oldPathRel);
            }
        }
      @endphp

      <div class="col-lg-4 col-sm-6 mb--30">
        <div class="card author-card h-100">
          <div class="card-body text-center">
            <img class="author-avatar mb--15" alt="{{ $row->name }}" src="{{ $img }}">
            <h4 class="author-name h5 mb--10">{{ $row->name }}</h4>
            <p class="mb--15">
              {{ $row->snippet($row->bio, 30) }}...
            </p>
            <a href="{{ route('author.public-profile', ['slug' => $row->slug]) }}" class="btn btn--primary btn-sm">
              View Profile
            </a>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="col-12">
      <div class="alert alert-info mb--30">No Result Found</div>
    </div>
  @endif
</div>


      {{-- Pagination (centered like theme pages toolbar/pagination areas) --}}
      <div class="row mt--20">
        <div class="col-12 d-flex justify-content-center">
          {{ $authors->links() }}
        </div>
      </div>

    </div>
  </main>

@endsection
