<footer id="footer"><!--Footer-->
		{{--<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>Helpmyworld Publishing</span></h2>
							<p>Get special promotions and deals everyday</p>
						</div>
					</div>
					<div class="col-sm-7">
                        <section id="slider"><!--slider-->
                        <div class="container">
                        <div class="row">
                        <div class="col-sm-12">
                            <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach($posters as $key => $poster)
                                        <li data-target="#slider-carousel" data-slide-to="0" @if($key==0) class="active" @endif></li>
                                    @endforeach
                                </ol>

                                <div class="carousel-inner">
                                    @foreach($posters as $key => $poster)
                                        <div class="item @if($key==0) active @endif">
                                            --}}{{--<a href="{{ $poster->link }}" title="poster 1"><img src="/public/images/frontend_images/posters/{{ $poster->image }}"--}}{{--
                                                                                                 --}}{{--width="1143" height="200">--}}{{--
                                            --}}{{--</a>--}}{{--<img src="/public/images/frontend_images/posters/{{ $poster->image }}"
                                                             width="1143" height="200">
                                        </div>
                                    @endforeach
                                </div>

                                <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>

                        </div>
                        </div>
                        </div>
                        </section><!--/slider-->


					</div>
					--}}{{--<div class="col-sm-3">--}}{{--
						--}}{{--<div class="address">--}}{{--
							--}}{{--<img src="images/home/map.png" alt="" />--}}{{--
							--}}{{--<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>--}}{{--
						--}}{{--</div>--}}{{--
					--}}{{--</div>--}}{{--
				</div>
			</div>
		</div>--}}

		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="{{ url('/cart') }}">My Cart</a></li>
								<li><a href="{{ url('/orders') }}">My Order </a></li>
                                @if(empty(Auth::check()))
                                    <li><a href="{{ url('/login-register') }}"></i> Login</a></li>
                                @else
                                    <li><a href="{{ url('/account') }}"> Account</a></li>
                                    <li><a href="{{ url('/user-logout') }}">Logout</a></li>
                                @endif
								<li><img src="/images/card.png" class="img-responsive" alt=""/></li>
							</ul>
						</div>
					</div>
					{{--<div class="col-sm-2">--}}
						{{--<div class="single-widget">--}}
							{{--<h2>Quock Shop</h2>--}}
							{{--<ul class="nav nav-pills nav-stacked">--}}
								{{--<li><a href="#">T-Shirt</a></li>--}}
								{{--<li><a href="#">Mens</a></li>--}}
								{{--<li><a href="#">Womens</a></li>--}}
								{{--<li><a href="#">Gift Cards</a></li>--}}
								{{--<li><a href="#">Shoes</a></li>--}}
							{{--</ul>--}}
						{{--</div>--}}
					{{--</div>--}}
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
                                <li><a href="{{url('page/shipping-policy')}}">Shipping Policy</a></li>
                                <li><a href="{{url('page/privacy-policy')}}">Privacy Policy</a></li>
                                <li><a href="{{url('page/cancellation-and-refund')}}">Cancellations and Refunds</a></li>
                                <li><a href="{{url('page/terms-of-service')}}">Terms And Conditions</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Helpmyworld</h2>
							<ul class="nav nav-pills nav-stacked">
                                <li><a href="{{route('about')}}">About Us</a></li>
                                <li><a href="{{route('contact')}}">Contact Us</a></li>
                                <li><a href="{{route('services')}}">Services</a></li>
                                <li><a href="{{route('blog')}}">Blog</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>Newsletter</h2>

                            <form action="{{ url('contact') }}" class="searchform" method="POST">
                                {{ csrf_field() }}

                                <input type="text"  id="email" name="email" placeholder="Your email address" />
                                <button type="submit" value="" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Get the most recent updates from <br />our site and be updated yourself...</p>
                            </form>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
                    <p>&copy; 2019 Helpmyworld Publishing. All rights reserved | Design by <a href="http://rorisangmaimane.co.za/">Rorisang Maimane</a></p>
					{{--<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>--}}
				</div>
			</div>
		</div>

	</footer><!--/Footer-->
