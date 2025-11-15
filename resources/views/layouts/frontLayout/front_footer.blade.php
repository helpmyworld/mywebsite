<footer class="site-footer">
    <div class="container">
        <div class="row justify-content-between section-padding">

            {{-- Column 1: Shop (from your old footer) --}}
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="footer-title">
                        <h3>Shop</h3>
                    </div>
                    <ul class="footer-list normal-list">
                        <li><a href="{{ url('/cart') }}">My Cart</a></li>
                        <li><a href="{{ url('/orders') }}">My Order</a></li>
                        @if(empty(Auth::check()))
                            <li><a href="{{ url('/login-register') }}">Login</a></li>
                        @else
                            <li><a href="{{ url('/account') }}">Account</a></li>
                            <li><a href="{{ url('/user-logout') }}">Logout</a></li>
                        @endif
                        <li>
                            <img src="/images/card.png" class="img-responsive" alt="Payment Methods"/>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Column 2: Policies (from your old footer) --}}
            <div class="col-xl-3 col-lg-2 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="footer-title">
                        <h3>Policies</h3>
                    </div>
                    <ul class="footer-list normal-list">
                        <li><a href="{{ url('page/shipping-policy') }}">Shipping Policy</a></li>
                        <li><a href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ url('page/cancellation-and-refund') }}">Cancellations and Refunds</a></li>
                        <li><a href="{{ url('page/terms-of-service') }}">Terms And Conditions</a></li>
                    </ul>
                </div>
            </div>

            {{-- Column 3: Information (from your old footer) --}}
            <div class="col-xl-3 col-lg-2 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="footer-title">
                        <h3>Information</h3>
                    </div>
                    <ul class="footer-list normal-list">
                        <li><a href="{{ url('page/manuscript-submissions') }}">Manuscript Submissions</a></li>                        
                        <li><a href="{{ url('/author/filter') }}">Authors</a></li>
                        <li><a href="{{ url('blog') }}">Blog</a></li>
                    </ul>
                </div>
            </div>

            {{-- Column 4: Newsletter (from your old footer — no JS) --}}
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="footer-title">
                        <h3>Newsletter</h3>
                    </div>
                    {{-- Convert to a simple POST form (no JS) --}}
                    <form action="{{ url('/add-subscriber-email') }}" method="POST" class="newsletter-form mb--30">
                        @csrf
                        <input
                            type="email"
                            name="subscriber_email"
                            id="subscriber_email"
                            class="form-control"
                            placeholder="Your email address"
                            required
                        >
                        <button type="submit" class="btn btn--primary w-100 mt-2">Subscribe</button>
                    </form>
                    {{-- Optional: server message area if you flash session messages --}}
                    @if(session('success'))
                        <div class="text-success small">{{ session('success') }}</div>
                    @endif
                    @if(session('failure'))
                        <div class="text-danger small">{{ session('failure') }}</div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Footer bottom (kept exactly from your footer, adapted to new container) --}}
    <div class="footer-bottom">
        <div class="container">
            <p class="copyright-text">
                &copy; 2017 - {{ date('Y') }} Helpmyworld Publishing. All rights reserved |
                Design by <a href="http://rorisangmaimane.com/">Rorisang Maimane</a>
            </p>
        </div>
    </div>
</footer>
