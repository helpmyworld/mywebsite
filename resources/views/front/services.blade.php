@extends('layouts.frontLayout.front_design')

@section('content')
<!-- START: Premium Publishing Tracks -->
<section class="inner-page-sec-padding-bottom">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center mb--30">
        <h2 class="mb--10">Our Publishing Tracks</h2>
        <p class="lead">We don’t sell books — we craft legacies. Choose the path that fits your transformation.</p>
      </div>
    </div>

    <div class="row mbn-30">
      <div class="col-lg-4 col-md-6 col-12 mb--30">
        <div class="card h-100">
          <div class="card-header">
            <h3 class="mb-0">Legacy Author Series</h3>
          </div>
          <div class="card-body">
            <p class="mb--10"><em>Heirloom-quality book + platform strategy.</em></p>
            <div class="accordion" id="legacy-track">
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">
                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#legacy-includes">
                      What’s Included
                    </button>
                  </h5>
                </div>
                <div id="legacy-includes" class="collapse show" data-parent="#legacy-track">
                  <div class="card-body">
                    <ul class="list-unstyled">
                      <li>• Strategy intensive</li>
                      <li>• Interviews & ghostwriting or developmental edit</li>
                      <li>• Premium design & hardcover first run</li>
                      <li>• Author photography</li>
                      <li>• Launch ritual</li>
                      <li>• 90-day PR</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">
                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#legacy-pricing">
                      Investment (Anchor Range)
                    </button>
                  </h5>
                </div>
                <div id="legacy-pricing" class="collapse" data-parent="#legacy-track">
                  <div class="card-body">
                    <p class="h4 mb--10">R 180,000 – R 350,000</p>
                    <p class="mb-0">We shape final quotes per scope. <a href="/promotion" class="btn btn-link p-0">See Plans</a></p>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">
                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#legacy-context">
                      Context & Upsells
                    </button>
                  </h5>
                </div>
                <div id="legacy-context" class="collapse" data-parent="#legacy-track">
                  <div class="card-body">
                    <p class="mb--10"><strong>Context:</strong> private-bank lounges / legacy dinners.</p>
                    <p class="mb-0"><strong>Upsell ladders:</strong> VIP launch film; numbered art‑print slipcase; family‑archive edition.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent">
            <a href="/promotion" class="btn btn--primary w-100">Explore Plans</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12 mb--30">
        <div class="card h-100">
          <div class="card-header">
            <h3 class="mb-0">Executive Manifesto</h3>
          </div>
          <div class="card-body">
            <p class="mb--10"><em>Your principles, bound. (40–80 pages)</em></p>
            <div class="accordion" id="manifesto-track">
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">
                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#manifesto-includes">
                      What’s Included
                    </button>
                  </h5>
                </div>
                <div id="manifesto-includes" class="collapse show" data-parent="#manifesto-track">
                  <div class="card-body">
                    <ul class="list-unstyled">
                      <li>• Concept workshop</li>
                      <li>• Editing & premium design</li>
                      <li>• Hardcover run (100–300 units)</li>
                      <li>• Keynote slide kit</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">
                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#manifesto-pricing">
                      Investment (Anchor Range)
                    </button>
                  </h5>
                </div>
                <div id="manifesto-pricing" class="collapse" data-parent="#manifesto-track">
                  <div class="card-body">
                    <p class="h4 mb--10">R 75,000 – R 150,000</p>
                    <p class="mb-0">Final scope determines quote. <a href="/promotion" class="btn btn-link p-0">See Plans</a></p>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">
                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#manifesto-context">
                      Context & Upsells
                    </button>
                  </h5>
                </div>
                <div id="manifesto-context" class="collapse" data-parent="#manifesto-track">
                  <div class="card-body">
                    <p class="mb--10"><strong>Context:</strong> professional bodies / corporate offsites.</p>
                    <p class="mb-0"><strong>Upsell ladders:</strong> corporate bulk orders; audiobook mini; LinkedIn article series.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent">
            <a href="/promotion" class="btn btn--primary w-100">Explore Plans</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12 mb--30">
        <div class="card h-100">
          <div class="card-header">
            <h3 class="mb-0">Classic Publishing</h3>
          </div>
          <div class="card-body">
            <p class="mb--10"><em>Editing, design, ISBN, print, distribution.</em></p>
            <div class="accordion" id="classic-track">
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">
                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#classic-includes">
                      What’s Included
                    </button>
                  </h5>
                </div>
                <div id="classic-includes" class="collapse show" data-parent="#classic-track">
                  <div class="card-body">
                    <ul class="list-unstyled">
                      <li>• Professional edit</li>
                      <li>• Cover & interior design</li>
                      <li>• ISBN & barcode</li>
                      <li>• Print management</li>
                      <li>• Basic launch support</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">
                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#classic-pricing">
                      Investment (Anchor Range)
                    </button>
                  </h5>
                </div>
                <div id="classic-pricing" class="collapse" data-parent="#classic-track">
                  <div class="card-body">
                    <p class="h4 mb--10">R 40,000 – R 95,000</p>
                    <p class="mb-0">Scope-based quoting. <a href="/promotion" class="btn btn-link p-0">See Plans</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent">
            <a href="/promotion" class="btn btn--primary w-100">Explore Plans</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 text-center">
        <p class="mt--10 mb--0"><small>Price logic: We’re not selling pages; we’re crafting cultural equity. Your book is an asset that earns reputation, speaking, and deal flow.</small></p>
      </div>
    </div>
  </div>
</section>
<!-- END: Premium Publishing Tracks -->






@endsection
