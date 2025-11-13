{{-- resources/views/partials/captcha_mews.blade.php --}}
<div class="mb-3">
  <label for="captcha" class="form-label">Captcha</label>

  <div class="d-flex align-items-center gap-3">
    <span id="captcha-image">{!! captcha_img() !!}</span>
    <button type="button" class="btn btn-outline-secondary btn-sm" id="captcha-reload" aria-label="Reload captcha">
      Reload
    </button>
  </div>

  <input
    type="text"
    name="captcha"
    id="captcha"
    class="form-control mt-2"
    placeholder="Type the text you see"
    required
  >

  @error('captcha')
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('captcha-reload');
    if (!btn) return;
    btn.addEventListener('click', function () {
      fetch('{{ url('reload-captcha') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function(r){ return r.json(); })
        .then(function(d){ document.getElementById('captcha-image').innerHTML = d.captcha; });
    });
  });
</script>
@endpush
