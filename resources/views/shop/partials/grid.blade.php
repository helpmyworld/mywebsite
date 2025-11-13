<div class="row g-3">
  @forelse($products as $product)
    @php
        use Illuminate\Support\Facades\Route;

        // Use slug if available; fallback to id
        $slug = $product->slug ?? $product->id;

        // Product show URL: prefer named route, else fallback to /product/{slug}
        $productUrl = Route::has('products.show')
            ? route('products.show', $slug)
            : url('/product/'.$slug);

        // Add-to-cart URL: prefer named route, else fallback to /cart/add/{id}
        $cartAddUrl = Route::has('cart.add')
            ? route('cart.add', $product->id)
            : url('/cart/add/'.$product->id);

        // Image accessor fallback chain
        $img = $product->main_image_url
            ?? $product->image_url
            ?? $product->image
            ?? asset('images/placeholder.png');

        $price     = isset($product->price) ? (float)$product->price : null;
        $salePrice = isset($product->sale_price) ? (float)$product->sale_price : null;
    @endphp

    <div class="col-6 col-md-4 col-lg-3">
      <article class="card h-100 product-card">
        <a href="{{ $productUrl }}" class="text-decoration-none">
          <img class="card-img-top" src="{{ $img }}" alt="{{ $product->name }}">
        </a>

        <div class="card-body">
          <a href="{{ $productUrl }}" class="stretched-link text-decoration-none">
            <h6 class="card-title text-truncate">{{ $product->name }}</h6>
          </a>

          <div class="mt-1">
            @if($salePrice !== null)
              <span class="fw-bold me-2">${{ number_format($salePrice, 2) }}</span>
              @if($price !== null)
                <span class="text-muted text-decoration-line-through">${{ number_format($price, 2) }}</span>
              @endif
            @elseif($price !== null)
              <span class="fw-bold">${{ number_format($price, 2) }}</span>
            @endif
          </div>
        </div>

        <div class="card-footer bg-white">
          <form method="POST" action="{{ $cartAddUrl }}">
            @csrf
            <button class="btn btn-sm btn-dark w-100">Add to cart</button>
          </form>
        </div>
      </article>
    </div>
  @empty
    <div class="col-12 text-center text-muted py-5">No products found.</div>
  @endforelse
</div>

@if(method_exists($products, 'links'))
  <div class="mt-3">{{ $products->links() }}</div>
@endif
