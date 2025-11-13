{{-- Include in your product create/edit form --}}
@php
  $allAuthors = \App\Models\Author::orderBy('name')->get(['id','name']);
  $selectedAuthors = isset($product)
      ? $product->authors()->pluck('authors.id')->all()
      : (old('author_ids') ?? []);
@endphp

<div class="mb-3">
  <label class="form-label">Authors (multi-select)</label>
  <select name="author_ids[]" class="form-select" multiple size="6">
    @foreach($allAuthors as $a)
      <option value="{{ $a->id }}" @if(in_array($a->id, (array)$selectedAuthors)) selected @endif>{{ $a->name }}</option>
    @endforeach
  </select>
  <div class="form-text">Hold Ctrl/Cmd to select multiple. Author not required.</div>
</div>

<div class="form-check form-switch mb-3">
  <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
         {{ old('is_featured', isset($product) ? $product->is_featured : false) ? 'checked' : '' }}>
  <label class="form-check-label" for="is_featured">Featured book</label>
</div>

<div class="form-check form-switch mb-3">
  <input class="form-check-input" type="checkbox" name="is_best_seller" value="1" id="is_best_seller"
         {{ old('is_best_seller', isset($product) ? $product->is_best_seller : false) ? 'checked' : '' }}>
  <label class="form-check-label" for="is_best_seller">Best seller (manual override)</label>
</div>
