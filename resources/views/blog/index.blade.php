{{-- resources/views/index.blade.php --}}
@extends('layouts.frontLayout.front_design')

@section('title', $pageTitle ?? 'Blog')

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
                        <li class="breadcrumb-item active">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- Main content area with right sidebar --}}
    <section class="inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row">
                {{-- Main column --}}
                <div class="col-lg-9 mb--40 mb-lg--0">
                    {{-- Grid spacing classes from theme --}}
                    <div class="row space-db-lg--60 space-db--30">

                        {{-- 
                            KEEP YOUR EXISTING DATA AND LOOP.
                            If your original index.blade used $posts (paginator/collection), this preserves it.
                            If you used a different variable, assign it to $__posts upstream or add another fallback here.
                        --}}
                        @php
                            // Non-invasive fallback mapping: prefer your existing variable names.
                            $__posts = $posts
                                ?? $articles
                                ?? $blogs
                                ?? $data
                                ?? collect(); // safe default
                        @endphp

                        @forelse($__posts as $post)
                            @php
                                // Non-invasive read of common fields (won't break if missing)
                                $title = $post->title
                                    ?? $post->name
                                    ?? $post['title']
                                    ?? $post['name']
                                    ?? 'Untitled';

                                $slug = $post->slug
                                    ?? $post['slug']
                                    ?? null;

                                // Derive link the same way your working index did, but safely fall back:
                                $link = isset($post->url) ? $post->url
                                    : (isset($post['url']) ? $post['url']
                                    : ($slug ? url('blog/'.$slug) : (method_exists($post, 'getUrl') ? $post->getUrl() : '#')));

                                // Image fallbacks
                                $img = $post->featured_image
                                    ?? $post->image
                                    ?? $post->image_url
                                    ?? $post['featured_image']
                                    ?? $post['image']
                                    ?? $post['image_url']
                                    ?? asset('image/others/blog-grid-1.jpg');

                                // Author fallbacks
                                $author = optional($post->author)->name
                                    ?? optional($post->user)->name
                                    ?? $post['author_name']
                                    ?? '—';

                                // Date display (keeps your formatting if you casted created_at)
                                try {
                                    $dateDisplay = isset($post->created_at) ? \Carbon\Carbon::parse($post->created_at)->format('d/m/Y')
                                        : (isset($post['created_at']) ? \Carbon\Carbon::parse($post['created_at'])->format('d/m/Y') : '');
                                } catch (\Throwable $e) {
                                    $dateDisplay = '';
                                }

                                // Excerpt fallbacks (does not modify your data)
                                $rawBody = $post->excerpt
                                    ?? $post->summary
                                    ?? $post->short_description
                                    ?? $post['excerpt']
                                    ?? $post['summary']
                                    ?? $post['short_description']
                                    ?? ($post->body ?? $post['body'] ?? $post->content ?? $post['content'] ?? '');

                                $excerpt = \Illuminate\Support\Str::limit(strip_tags($rawBody), 160);
                            @endphp

                            <div class="col-lg-4 col-md-6 mb-lg--60 mb--30">
                                <div class="blog-card card-style-grid">
                                    <a href="{{ $link }}" class="image d-block">
                                        <img src="{{ $img }}" alt="{{ $title }}">
                                    </a>
                                    <div class="card-content">
                                        <h3 class="title"><a href="{{ $link }}">{{ $title }}</a></h3>
                                        @if($dateDisplay || $author)
                                            <p class="post-meta">
                                                @if($dateDisplay)<span>{{ $dateDisplay }}</span>@endif
                                                @if($dateDisplay && $author) | @endif
                                                @if($author)<a href="javascript:void(0)">{{ $author }}</a>@endif
                                            </p>
                                        @endif
                                        <article>
                                            <h2 class="sr-only">Blog Article</h2>
                                            <p>{{ $excerpt }}</p>
                                            <a href="{{ $link }}" class="blog-link">Read More</a>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- Empty state, styled to theme, but does not alter your logic --}}
                            <div class="col-12">
                                <div class="alert alert-info" role="alert">
                                    No posts to display.
                                </div>
                            </div>
                        @endforelse

                        {{-- Preserve your existing pagination if it exists on $posts --}}
                        @if(method_exists($__posts, 'links'))
                            <div class="col-12 mt-4">
                                {{ $__posts->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right Sidebar (kept as your include; we’ll restyle the partial next) --}}
                <div class="col-lg-3">
                    <div class="inner-page-sidebar">
                        @include('layouts.sidebar')
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Optional: theme brand slider (leave in place if your layout uses it) --}}
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
