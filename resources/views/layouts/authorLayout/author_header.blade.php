{{--
<!--Header-part-->
<div id="header">
  <h2><a href="{{ url('/')}}">Help My World</a></h2>
</div>
<!--close-Header-part-->


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=""><a title="" href="{{ url('/account') }}"><i class="icon icon-cog"></i> <span class="text">Profile</span></a></li>
    <li class=""><a title="" href="{{ url('/user-logout') }}"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-serch-->--}}
<header class="topbar" data-navbarbg="skin5">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header" data-logobg="skin5">
      <!-- This is for the sidebar toggle which is visible on mobile only -->
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <a class="navbar-brand" href="/">
        <!-- Logo icon -->
        <b class="logo-icon p-l-10">
          <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
          <!-- Dark Logo icon -->
          {{--<img src="{{asset('author/assets/images/logo-icon.png')}}" alt="homepage" class="light-logo" />--}}

        </b>
        <!--End Logo icon -->
        <!-- Logo text -->
        <span class="logo-text">
                             <!-- dark Logo text -->
                             <img src="{{asset('author/assets/images/logo-text.png')}}" alt="homepage" class="light-logo" />

                        </span>
        <!-- Logo icon -->
        <!-- <b class="logo-icon"> -->
        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
        <!-- Dark Logo icon -->
        <!-- <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

        <!-- </b> -->
        <!--End Logo icon -->
      </a>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Toggle which is visible on mobile only -->
      <!-- ============================================================== -->
      <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
      <!-- ============================================================== -->
      <!-- toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-left mr-auto">
        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
        <!-- ============================================================== -->
        <!-- create new -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-none d-md-block">Manage<i class="fa fa-angle-down"></i></span>
            <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{route('author.questions.create')}}">Post Question</a>
            <a class="dropdown-item" href="{{route('author.blogs.create')}}">Post Blog</a>
            <a class="dropdown-item" href="{{route('blog')}}">Blog Posts</a>
            <a class="dropdown-item" href="{{route('questions.index')}}">Questions</a>
            {{--<a class="dropdown-item" href="#">Writing Tools</a>--}}
          </div>
        </li>
        <!-- ============================================================== -->
        <!-- Search -->
        <!-- ============================================================== -->
        <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
          <form class="app-search position-absolute">
            <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
          </form>
        </li>
        @if(auth()->user()->premium_subscription())
          <li class="nav-item"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"></a>
            <a href="{{route('author.subscriptions.browse')}}" class="btn btn-success"><i class="mdi mdi-check"></i> Premium Member</a>
          </li>
          @else
          <li class="nav-item"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"></a>
            <a href="{{route('author.subscriptions.browse')}}?subscription=premium" class="btn btn-success"><i class="mdi mdi-cash-multiple"></i> Become a Premium Member</a>
          </li>
          @endif
      </ul>
      <!-- ============================================================== -->
      <!-- Right side toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-right">

        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('author/assets/images/users/1.jpg')}}" alt="user" class="rounded-circle" width="31"></a>
          <div class="dropdown-menu dropdown-menu-right user-dd animated">
            <a class="dropdown-item" href="{{ route('author.edit-profile') }}"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
{{--            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-wallet m-r-5 m-l-5"></i> My Balance</a>
            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> Inbox</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>--}}
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ url('/user-logout') }}"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
            {{--<div class="dropdown-divider"></div>
            <div class="p-l-30 p-10"><a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a></div>--}}
          </div>
        </li>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
      </ul>
    </div>
  </nav>
</header>