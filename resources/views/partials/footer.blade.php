<footer class="border-top mt-5 py-4">
  <div class="container-xl d-flex justify-content-between flex-wrap gap-3">
    <div>© {{ date('Y') }} {{ config('app.name') }}</div>
    <div class="d-flex gap-3">
      <a href="{{ route('pages.contact') }}">Contact</a>
      <a href="{{ route('pages.privacy') }}">Privacy</a>
      <a href="{{ route('pages.terms') }}">Terms</a>
    </div>
  </div>
</footer>
