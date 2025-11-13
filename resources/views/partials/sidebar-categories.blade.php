<aside class="bw-sidebar border rounded">
  <div class="p-3 border-bottom d-flex align-items-center">
    <i class="bi bi-list fs-5 me-2"></i>
    <strong>Browse categories</strong>
  </div>
  <ul class="list-group list-group-flush">
    @foreach(($sidebarCategories ?? []) as $cat)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('categories.show', $cat->slug) }}" class="text-decoration-none">{{ $cat->name }}</a>
        <i class="bi bi-chevron-right"></i>
      </li>
    @endforeach
  </ul>
</aside>

{{-- Optional mobile offcanvas --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="bwCategories">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Browse categories</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body p-0">
    <ul class="list-group list-group-flush">
      @foreach(($sidebarCategories ?? []) as $cat)
        <li class="list-group-item"><a href="{{ route('categories.show', $cat->slug) }}">{{ $cat->name }}</a></li>
      @endforeach
    </ul>
  </div>
</div>
