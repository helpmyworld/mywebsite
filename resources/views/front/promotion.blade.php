
@extends('layouts.frontLayout.front_design')

@section('content')

<section class="inner-page-sec-padding-bottom">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center mb--20">
        <h2 class="mb--10">Plans</h2>
        <p class="lead">Use these as anchor prices; we shape final quotes per scope.</p>
      </div>
    </div>

    <div class="row mbn-30">
      @foreach($subscriptions as $row)
        @continue($row->title == 'Indie.Africa')
        <div class="col-lg-4 col-md-6 col-12 mb--30">
          <div class="card h-100">
            <div class="card-header">
              <h3 class="mb-0">{{ $row->title }}</h3>
            </div>

            <div class="card-body">
              <p class="h4 mb--10">R{{ $row->price }}<span class="small">/month</span></p>
              <p class="mb--10"><small>Billed monthly</small></p>

              <ul class="list-unstyled mb--0">
                @foreach($row->benefits as $benefit)
                  <li>• {{ $benefit->name }}</li>
                @endforeach
              </ul>
            </div>

            <div class="card-footer bg-transparent">
              @auth
                @if(auth()->user()->active_subscription() && auth()->user()->active_subscription()->subscription_id == $row->id)
                  <a href="javascript:;" class="btn btn--primary w-100">ACTIVE</a>
                @else
                  <a href="{{ url('/login-register') }}" class="btn btn--primary w-100 text-uppercase buy loader-trigger">I'm Interested</a>
                @endif
              @else
                <a href="{{ url('/login-register') }}" class="btn btn--primary w-100 text-uppercase buy loader-trigger">I'm Interested</a>
              @endauth
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>


@endsection
