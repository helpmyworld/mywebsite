{{-- resources/views/layouts/sidebar.blade.php --}}

   <div class="inner-page-sidebar">
    {{-- Search block (unchanged) --}}
    <div class="single-block">
        <h2 class="sidebar-title mb--30">Search</h2>
        <div class="site-mini-search">
            <input type="text" placeholder="Search">
            <button><i class="fas fa-search"></i></button>
        </div>
    </div>

    {{-- BLOG ARCHIVES (from DB) --}}
    <div class="single-block">
        <h2 class="sidebar-title mb--30">BLOG ARCHIVES</h2>
        <ul class="sidebar-list mb--30">
            @forelse($archives as $row)
                @php
                    // $row->ym = 'YYYY-MM', $row->month = 'Month YYYY', $row->count = total posts
                    [$year, $month] = explode('-', $row->ym);
                @endphp
                <li>
                    <a href="{{ url('/posts/archive/'.$year.'/'.$month) }}">
                        {{ $row->month }} ({{ $row->count }})
                    </a>
                </li>
            @empty
                <li><em>No archives yet.</em></li>
            @endforelse
        </ul>
    </div>

    {{-- Categories (your loop kept as-is) --}}
    <div class="single-block">
        <h2 class="sidebar-title mb--30">Categories</h2>
        <ul class="sidebar-list">
            @foreach($cats as $cat)
                <li>
                    <a href="/posts/cats/{{ $cat }}">{{ $cat }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- RECENT POSTS (from DB) --}}
    <div class="single-block">
        <h2 class="sidebar-title mb--30">RECENT POSTS</h2>
        <ul class="sidebar-list">
            @forelse($recentPosts as $rp)
                <li>
                    <a href="{{ url('/blog/'.$rp->slug) }}">{{ $rp->title }}</a>
                </li>
            @empty
                <li><em>No recent posts.</em></li>
            @endforelse
        </ul>
    </div>

    {{-- Tags (from DB) --}}
    <div class="single-block">
        <h2 class="sidebar-title mb--30">Tags</h2>
        <ul class="sidebar-tag-list">
            @forelse($tags as $tag)
                <li><a href="/posts/tags/{{ $tag->name }}">{{ $tag->name }}</a></li>
            @empty
                <li><em>No tags yet.</em></li>
            @endforelse
        </ul>
    </div>

    {{-- Promo Block (unchanged) --}}
    <div class="single-block">
        <a href="#" class="promo-image sidebar">
            <img src="image/others/home-side-promo.jpg" alt="">
        </a>
    </div>
</div>

