@extends('layouts.frontLayout.front_design')

@section('content')
<div class="faq-area inner-page-sec-padding-bottom">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner">
                    <h1 class="mb-4">About <strong>Helpmyworld Publishing</strong></h1>
                    <p class="lead">The book that changes your life is the book you write.</p>
                    <p>Every leader has a story worth immortalising.<br>
                       At Helpmyworld Publishing, we craft legacies.<br>
                       Your words become cultural equity: wisdom that outlives wealth and builds authority, legacy, and immortality.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <img src="/images/frontend_images/1500x500.jpg" alt="About Helpmyworld" class="img-fluid rounded shadow">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="accordion" id="about-accordion">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#about-1">
                                    Who We Are
                                </button>
                            </h5>
                        </div>
                        <div id="about-1" class="collapse show" data-parent="#about-accordion">
                            <div class="card-body">
                                <p>Our purpose is to help leaders, entrepreneurs, and visionaries transform their experiences into enduring works of legacy.</p>
                                <p>We believe your story is not content — it’s capital. It’s proof that your life meant something, and that your wisdom deserves to live beyond you.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#about-2">
                                    Our Mission
                                </button>
                            </h5>
                        </div>
                        <div id="about-2" class="collapse" data-parent="#about-accordion">
                            <div class="card-body">
                                <p>We transform experience into legacy - every story that should be remembered — is written, bound, and celebrated</p>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#about-awards">
                                        Awards & Recognition
                                    </button>
                                </h5>
                            </div>
                            <div id="about-awards" class="collapse" data-parent="#about-accordion">
                                <div class="card-body">
                                    <p><strong>Help My World Publishing</strong> has been recognised twice by the 
                                       <strong>Department of Sport, Arts and Culture (DSAC)</strong> — in 
                                       <strong>2024</strong> and <strong>2025</strong> — for its pivotal role in 
                                       advancing literature and culture in South Africa.</p>
                                    <p>This national recognition celebrates our contribution to author development and
                                       our work in transforming lived experiences into literary legacy.</p>

                                    <div class="row justify-content-center mt-4">
                                        <div class="col-md-6 mb-3">
                                            <img src="/images/awards/BULK0240.JPG" alt="DSAC Certificate 2024" class="img-fluid rounded shadow">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <img src="/images/awards/KCLG5097.JPG" alt="DSAC Certificate 2025" class="img-fluid rounded shadow">
                                        </div>
                                    </div>

                                    <p class="mt-3 text-muted"><em>“For their pivotal role in advancing literature and culture.”</em></p>
                                </div>
                            </div>
                        </div>

                    </div>

                                     {{-- WHAT WE OFFER --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#about-3">
                                    What We Offer
                                </button>
                            </h5>
                        </div>
                        <div id="about-3" class="collapse" data-parent="#about-accordion">
                            <div class="card-body">
                                <section class="section-padding bg-white">
                                  <div class="container">
                                    <div class="text-center mb-4">
                                      <p class="text-muted">How we turn experience into enduring cultural equity.</p>
                                    </div>

                                    <div class="table-responsive">
                                      <table class="table table-bordered table-striped text-center align-middle mb-0">
                                        <thead class="thead-light">
                                          <tr>
                                            <th scope="col" style="min-width:160px;">Segment</th>
                                            <th scope="col">Shift</th>
                                            <th scope="col">Line</th>
                                            <th scope="col">CTA</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <th scope="row">Wealth Builders</th>
                                            <td><em>From “investment portfolio” to “intellectual portfolio”</em></td>
                                            <td>“Your voice appreciates faster than your assets.”</td>
                                            <td><strong>“Publish your legacy.”</strong></td>
                                          </tr>
                                          <tr>
                                            <th scope="row">Leaders</th>
                                            <td><em>From “managing people” to “shaping culture”</em></td>
                                            <td>“Leaders don’t just build teams. They build texts.”</td>
                                            <td><strong>“Write the playbook.”</strong></td>
                                          </tr>
                                          <tr>
                                            <th scope="row">Creatives</th>
                                            <td><em>From “expressing” to “owning intellectual property”</em></td>
                                            <td>“Your story isn’t content. It’s capital.”</td>
                                            <td><strong>“Package it.”</strong></td>
                                          </tr>
                                          <tr>
                                            <th scope="row">Philanthropists</th>
                                            <td><em>From “impact” to “immortality”</em></td>
                                            <td>“Books outlive buildings.”</td>
                                            <td><strong>“Fund voices that last.”</strong></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </section>
                            </div>
                        </div>
                    </div>

                    {{-- CLOSING STATEMENT --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#about-4">
                                    Our Promise
                                </button>
                            </h5>
                        </div>
                        <div id="about-4" class="collapse" data-parent="#about-accordion">
                            <div class="card-body">
                                <p>At <strong>Helpmyworld Publishing</strong>, we turn lives into literature — so that what you’ve learned never dies with you.</p>
                            </div>
                        </div>
                    </div>

                </div><!-- /accordion -->
            </div>
        </div>
    </div>
</div>
@endsection