<?php use App\Http\Controllers\Controller;
$mainCategories =  Controller::mainCategories();
?>
<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +27 12 942 9433</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> rorisang@helpmyworld.co.za</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="https://web.facebook.com/Rorisang-Maimane-136144673665695/"><i class="fa fa-facebook"></i></a></li>
								<li><a href="https://twitter.com/RorisangMaimane"><i class="fa fa-twitter"></i></a></li>
								<li><a href="https://www.linkedin.com/in/rorisang-maimane-802b0414b/"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="{{ url('./')}}"><img src="{{ asset('/images/frontend_images/banners/logo.jpg') }}"alt="" width="180" height="120" /></a>



						</div>


						{{--<div class="btn-group pull-right">--}}
							{{--<div class="btn-group">--}}
								{{--<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">--}}
									{{--USA--}}
									{{--<span class="caret"></span>--}}
								{{--</button>--}}
								{{--<ul class="dropdown-menu">--}}
									{{--<li><a href="#">Canada</a></li>--}}
									{{--<li><a href="#">UK</a></li>--}}
								{{--</ul>--}}
							{{--</div>--}}
							{{----}}
							{{--<div class="btn-group">--}}
								{{--<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">--}}
									{{--DOLLAR--}}
									{{--<span class="caret"></span>--}}
								{{--</button>--}}
								{{--<ul class="dropdown-menu">--}}
									{{--<li><a href="#">Canadian Dollar</a></li>--}}
									{{--<li><a href="#">Pound</a></li>--}}
								{{--</ul>--}}
							{{--</div>--}}
						{{--</div>--}}
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">

								{{--<li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li>--}}
								<li><a href="{{ url('/orders') }}"><i class="fa fa-crosshairs"></i> Orders</a></li>
								<li><a href="{{ url('/cart') }}"><i class="fa fa-shopping-cart"></i> Cart</a></li>
								@if(empty(Auth::check()))
									<li><a href="{{ url('/login-register') }}"><i class="fa fa-lock"></i> Login</a></li>
								@else
									@if(auth()->user()->type == "Author")
										<li><a href="{{route('author.dashboard')}}"><i class="fa fa-user"></i> Account</a></li>
										@else
										<li><a href="{{ url('/account') }}"><i class="fa fa-user"></i> Account</a></li>
										@endif

									<li><a href="{{ url('/user-logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{ url('./')}}" class="active">Home</a></li>
                <li><a href="{{url ('books')}}">Books</a></li>
                <li><a href="{{route('promotion')}}">Special Promotion</a></li>
                <li class="dropdown"><a href="{{route('services')}}">Services<i class="fa fa-angle-down"></i></a>
									<ul role="menu" class="sub-menu">
										<li><a href="{{route('services')}}">Publishing </a></li>
										<li><a href="{{url('hosting-internet')}}">Hosting and Internet</a></li>
										<li><a href="{{url('software-app-development')}}">Software Development</a></li>
										
									</ul>
								</li>
                {{--<li><a href="{{url('page/manuscript-submissions')}}">Manuscript Submissions</a></li>--}}
                <li><a href="{{url ('manuscript-submissions')}}">Manuscript Submissions</a></li>
                  {{--<li><a href="{{route('blog')}}">Blog</a></li>--}}
								<li><a href="{{route('questions.index')}}">Questions</a></li>
                <li><a href="{{url('page/publishing-faq')}}">FAQ</a></li>
                <li><a href="{{route('about')}}">About Us</a></li>
                {{--<li><a href="404.html">404</a></li>--}}
                <li><a href="{{route('contact')}}">Contact Us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<form action="{{ url('/search-products') }}" method="post">{{ csrf_field() }}
								<input type="text" placeholder="Search Product" name="product" />
								<button type="submit" style="border:0px; height:35px; margin-left:-0px">Go</button>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
