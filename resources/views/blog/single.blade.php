{{-- resources/views/single.blade.php --}}
@extends('layouts.frontLayout.front_design')

@section('title', isset($pageTitle) ? $pageTitle : (isset($post->title) ? $post->title : 'Blog Details'))

@section('content')
<div class="site-wrapper" id="top">

    {{-- Breadcrumb (theme style) --}}
    <section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Blog Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- Content + Right Sidebar --}}
    <section class="inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row">
                {{-- MAIN: 9 cols --}}
                <div class="col-lg-9 mb--40 mb-lg--0">
                    <div class="blog-post post-details mb--50">

                        {{-- FEATURE IMAGE (keep your original output here) --}}
                        <div class="blog-image">
                            {{-- Main featured image --}}
                                @if(!empty($post->image))
                                <img src="{{ asset('/images/' . $post->image) }}" alt="{{ $post->title }}"  width="320" >
                                @endif

                        </div>

                        {{-- POST CONTENT --}}
                        <div class="blog-content mt--30">
                            <header>
                                {{-- TITLE (leave your current echo intact; wrapper adds theme class) --}}
                                <h3 class="blog-title">
                                    {{ $post->title ?? ($title ?? '') }}
                                </h3>

                                {{-- META (author + date) — keep your current bindings; wrappers only --}}
                                <div class="post-meta">
                                    <span class="post-author">
                                        <i class="fas fa-user"></i>
                                        <span class="text-gray">Posted by : </span>
                                        {{ $post->author->name ?? ($post->author_name ?? ($author ?? '')) }}
                                    </span>
                                    <span class="post-separator">|</span>
                                    <span class="post-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <span class="text-gray">On : </span>
                                        {{ isset($post->created_at) ? \Carbon\Carbon::parse($post->created_at)->format('F d, Y') : ($date ?? '') }}
                                    </span>
                                </div>
                            </header>

                            <article>
                                <h3 class="d-none sr-only">blog-article</h3>
                                {{-- BODY/CONTENT (keep your current rendering exactly) --}}
                                {!! $post->body ?? ($post->content ?? ($content ?? '')) !!}
                                {{-- If your original uses something else, paste it here unchanged --}}
                            </article>

                            {{-- TAGS / META FOOTER (keep your current tags rendering) --}}
                            @if(!empty($tags) || !empty($post->tags))
                                <footer class="blog-meta">
                                    {{-- Example wrapper; keep your existing tag loop inside --}}
                                    {{-- <div>TAGS: @foreach($post->tags as $t)<a href="#">{{ $t->name }}</a>@endforeach</div> --}}
                                </footer>
                            @endif
                        </div>
                    </div>

                    {{-- SHARE BLOCK (styling only; keep your actual links if you have them) --}}
                    <div class="share-block mb--50">
                        <h3>Share Now</h3>
                        <div class="social-links justify-content-center mt--10">
                            {{-- If you already have share buttons, place them here unchanged --}}
                            <a href="#" class="single-social social-rounded"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="single-social social-rounded"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="single-social social-rounded"><i class="fab fa-pinterest-p"></i></a>
                            <a href="#" class="single-social social-rounded"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    {{-- COMMENTS LIST (keep your existing loop/partials; wrapper adds theme classes) --}}
                    @if(!empty($comments) || !empty($post->comments))
                    <div class="comment-block-wrapper mb--50">
                        <h3>{{ isset($comments) ? count($comments) : (isset($post->comments) ? $post->comments->count() : 0) }} Comments</h3>

                        {{-- Example structure; paste your existing @foreach for comments here --}}
                        {{-- @foreach($post->comments as $c)
                            <div class="single-comment">
                                <div class="comment-avatar">
                                    <img src="{{ $c->avatar_url ?? asset('image/icon/author-logo.png') }}" alt="">
                                </div>
                                <div class="comment-text">
                                    <h5 class="author"><a href="#">{{ $c->author_name }}</a></h5>
                                    <span class="time">{{ $c->created_at->format('F d, Y \a\t h:i a') }}</span>
                                    <p>{{ $c->body }}</p>
                                </div>
                                <a href="#" class="btn btn-outlined--primary btn-rounded reply-btn">Reply</a>
                            </div>
                        @endforeach --}}
                    </div>
                    @endif

                    {{-- REPLY/COMMENT FORM (keep your existing form action/fields; wrapper adds theme classes) --}}
                    <div class="replay-form-wrapper">
                        <h3 class="mt-0">LEAVE A REPLY</h3>
                        <p>Your email address will not be published. Required fields are marked *</p>

                        {{-- KEEP your current form exactly; only the outer classes below are new --}}
                        <form action="{{ $commentPostUrl ?? '#' }}" method="post" class="blog-form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message">Comment</label>
                                        <textarea name="message" id="message" cols="30" rows="10" class="form-control">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="text" id="website" name="website" class="form-control" value="{{ old('website') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="submit-btn">
                                        <button type="submit" class="btn btn-black">Post Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- If your original form differs, paste it here unchanged and keep this wrapper --}}
                    </div>
                </div>

                {{-- SIDEBAR: 3 cols (keeps your include exactly) --}}
                <div class="col-lg-3">
                    <div class="inner-page-sidebar">
                        @include('layouts.sidebar')
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Optional Brand Slider (leave or remove per your theme usage) --}}
    <section class="section-margin">
        <h2 class="sr-only">Brand Slider</h2>
        <div class="container">
            <div class="brand-slider sb-slick-slider border-top border-bottom"
                 data-slick-setting='{"autoplay": true,"autoplaySpeed": 8000,"slidesToShow": 6}'
                 data-slick-responsive='[
                    {"breakpoint":992,"settings":{"slidesToShow": 4}},
                    {"breakpoint":768,"settings":{"slidesToShow": 3}},
                    {"breakpoint":575,"settings":{"slidesToShow": 3}},
                    {"breakpoint":480,"settings":{"slidesToShow": 2}},
                    {"breakpoint":320,"settings":{"slidesToShow": 1}}
                 ]'>
                <div class="single-slide"><img src="{{ asset('image/others/brand-1.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-2.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-3.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-4.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-5.jpg') }}" alt=""></div>
                <div class="single-slide"><img src="{{ asset('image/others/brand-6.jpg') }}" alt=""></div>
            </div>
        </div>
    </section>
</div>
@endsection
