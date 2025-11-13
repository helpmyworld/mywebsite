@extends('layouts.frontLayout.front_design')

@section('content')
<div class="container py-4">
  <h1 class="mb-4">Publishing Packages</h1>
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h3 class="h5">Starter</h3>
          <p class="text-muted">Best for first‑time authors.</p>
          <ul class="mb-3">
            <li>Manuscript assessment (up to 30k words)</li>
            <li>Basic copyedit</li>
            <li>Simple cover design</li>
            <li>ISBN & barcode</li>
            <li>Basic eBook conversion</li>
          </ul>
          <a href="{{ route('quote.create') }}" class="btn btn-outline-primary w-100">Request a Quote</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 border-primary">
        <div class="card-body">
          <h3 class="h5">Standard</h3>
          <p class="text-muted">Most popular for complete launches.</p>
          <ul class="mb-3">
            <li>Full copyedit (up to 60k words)</li>
            <li>Custom cover + interior layout</li>
            <li>ISBN, barcode, print setup</li>
            <li>eBook + distribution setup</li>
            <li>Launch page on your author site</li>
          </ul>
          <a href="{{ route('quote.create') }}" class="btn btn-primary w-100">Request a Quote</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h3 class="h5">Pro</h3>
          <p class="text-muted">For premium positioning and scale.</p>
          <ul class="mb-3">
            <li>Developmental edit + copyedit</li>
            <li>Premium cover + illustrated interior</li>
            <li>Print & eBook distribution</li>
            <li>Author website landing + email capture</li>
            <li>3‑week launch plan templates</li>
          </ul>
          <a href="{{ route('quote.create') }}" class="btn btn-outline-primary w-100">Request a Quote</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
