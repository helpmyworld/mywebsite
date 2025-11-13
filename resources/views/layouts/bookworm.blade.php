<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name'))</title>

  {{-- Bookworm assets (copy from the theme to public/bookworm/...) --}}
  <link rel="stylesheet" href="{{ asset('bookworm/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bookworm/css/style.css') }}">
  {{-- If the theme ships fonts/icons as CSS files, include them too --}}
  @stack('styles')
</head>
<body class="bookworm">
  @include('partials.header')   {{-- top bar, nav, search, icons --}}
  <div class="container-xl py-3">
    @yield('above-content')     {{-- e.g., hero */}
    <div class="row">
      <aside class="col-12 col-lg-3 d-none d-lg-block">
        @include('partials.sidebar-categories')
      </aside>
      <section class="col-12 col-lg-9">
        @yield('content')
      </section>
    </div>
  </div>
  @include('partials.footer')

  <script src="{{ asset('bookworm/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('bookworm/js/theme.js') }}"></script>
  @stack('scripts')
</body>
</html>
