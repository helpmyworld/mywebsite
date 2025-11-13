@extends('layouts.frontLayout.front_design')

@section('title', 'Contact Us')

@section('content')

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <h2 class="sr-only">Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-area section-padding">
    <div class="container">
        <div class="row">

            <!-- Contact Form -->
            <div class="col-lg-8 mb--40 mb-lg--0">
                <div class="contact-form">
                    <h2 class="h3 mb--30 text-center">Get In Touch</h2>

                    @if(Session::has('flash_message_success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_success') !!}</strong>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('contact') }}" method="post" id="main-contact-form" class="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb--20">
                                <input type="text" name="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="col-md-6 mb--20">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="col-md-12 mb--20">
                                <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                            </div>
                            <div class="col-md-12 mb--20">
                                <textarea name="message" rows="8" class="form-control" placeholder="Your Message Here" required></textarea>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn--primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="contact-info-wrapper">
                    <h2 class="h3 mb--25 text-center">Contact Info</h2>
                    <ul class="contact-list mb--20">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            Kamassie Gardens, Unit 7<br>
                            77 Kamassie Crescent, Moreleta Park<br>
                            0044
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            Tel: 081 022 7831 &nbsp;|&nbsp; 074 215 4262
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:info@helpmyworld.co.za">info@helpmyworld.co.za</a>
                        </li>
                    </ul>

                    <h2 class="h4 mb--15 text-center">Social Networking</h2>
                    <ul class="social-list list-inline justify-content-center mb-0">
                        <li class="list-inline-item">
                            <a href="https://web.facebook.com/Helpmyworldpty-117942945557501/">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/HelpmyworldPty">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
