<?php $url = url()->current(); ?>
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li <?php if (preg_match("/dashboard/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
      @if(Session::get('adminDetails')['categories_access']==1)
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/categor/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-category/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-category')}}">Add Category</a></li>
        <li <?php if (preg_match("/view-categories/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-categories')}}">View Categories</a></li>
      </ul>
    </li>
      @endif
      @if(Session::get('adminDetails')['products_access']==1)
     <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/product/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-product/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-product')}}">Add Product</a></li>
        <li <?php if (preg_match("/view-products/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-products')}}">View Products</a></li>
      </ul>
    </li>
      @endif
      @if(Session::get('adminDetails')['coupons_access']==1)
          <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/coupon/i", $url)){ ?> style="display: block;" <?php } ?>>
            <li <?php if (preg_match("/add-coupon/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-coupon')}}">Add Coupon</a></li>
            <li <?php if (preg_match("/view-coupons/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-coupons')}}">View Coupons</a></li>
          </ul>
        </li>
      @endif

      @if(Session::get('adminDetails')['orders_access']==1)
          <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Orders</span> <span class="label label-important">1</span></a>
          <ul <?php if (preg_match("/orders/i", $url)){ ?> style="display: block;" <?php } ?>>
            <li <?php if (preg_match("/view-orders/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-orders')}}">View Orders</a></li>
          </ul>
        </li>
      @endif
      @if(Session::get('adminDetails')['banners_access']==1)

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Banners</span> <span class="label label-important">2</span></a>
      <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-banner')}}">Add Banner</a></li>
        <li <?php if (preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-banners')}}">View Banners</a></li>
      </ul>
    </li>
      @endif
      @if(Session::get('adminDetails')['posters_access']==1)

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Poster</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li <?php if (preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-poster')}}">Add Poster</a></li>
              <li <?php if (preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-poster')}}">View Poster</a></li>
          </ul>
      </li>
      @endif
      @if(Session::get('adminDetails')['users_access']==1)

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Users</span> <span class="label label-important">1</span></a>
      <ul <?php if (preg_match("/users/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/view-users/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-users')}}">View Users</a></li>
      </ul>
    </li>
      @endif

      @if(Session::get('adminDetails')['admins_access']==1)

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Admins</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/admins/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li <?php if (preg_match("/view-admins/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-admins')}}">View Admins</a></li>
              <li <?php if (preg_match("/add-admins/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-admin')}}">Add Admins</a></li>
          </ul>
      </li>
        @endif
      @if(Session::get('adminDetails')['posts_access']==1)
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Posts</span> <span class="label label-important">3</span></a>
          <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li <?php if (preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>><a href=" {{route ('posts.create')}}">Add Post</a></li>
              <li <?php if (preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>><a href="">Post Edit</a></li>
              <li <?php if (preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>><a href="{{route('posts.index')}}">View Posts</a></li>
          </ul>
      </li>
      @endif

      @if(Session::get('adminDetails')['tags_access']==1)
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Tags</span> <span class="label label-important">1</span></a>
          <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li <?php if (preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>><a href=" {{route('tags.index')}}">Add Tags</a></li>
          </ul>
      </li>
        @endif

      @if(Session::get('adminDetails')['banners_access']==1)
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Post Category</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li <?php if (preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>><a href=" {{route('cats.index')}}">Add Post Category</a></li>
          </ul>
      </li>
      @endif
      
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>CMS Pages</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li <?php if (preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>><a href=" {{url ('/admin/add-cms-page')}}">Add CMS Pages</a></li>
              <li <?php if (preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-cms-pages')}}">View CMS Pages</a></li>
          </ul>
      </li>
       
      @if(Session::get('adminDetails')['manuscripts_access']==1)

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Manuscript</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/manuscript/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li <?php if (preg_match("/manuscript/i", $url)){ ?> class="active" <?php } ?>><a href="{{ route('admin.manuscripts.index')}}">View Manuscripts</a></li>
              <li <?php if (preg_match("/order/i", $url)){ ?> class="active" <?php } ?>><a href="{{ route('admin.manuscript.orders.index')}}">View Orders</a></li>
          </ul>
      </li>
      @endif

      @if(Session::get('adminDetails')['benefits_access']==1)
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Subscription</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/subscription/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li><a href="{{ route('admin.subscription.benefits.index')}}">Manage Benefit</a></li>
              <li><a href="{{ route('admin.subscriptions.index')}}">Manage Subscription</a></li>
          </ul>
      </li>
      @endif

      @if(Session::get('adminDetails')['user_subscription_access']==1)
      <li><a href="{{ route('admin.subscription.authors.index')}}">Active Subscriptions</a></li>
        @endif


      @if(Session::get('adminDetails')['works_access']==1)
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Website Functions</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/work/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li><a href="{{ route('admin.work.index')}}">Manage Website Functions</a></li>
              <li><a href="{{ route('admin.websites.index')}}">Add Website Packages</a></li>
          </ul>
      </li>
        @endif

      @if(Session::get('adminDetails')['hosts_access']==1)
      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Hosting Services</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/capacity/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li><a href="{{ route('admin.capacity.index')}}">Manage Hosting Functions</a></li>
              <li><a href="{{ route('admin.hosts.index')}}">Add Hosting Packages</a></li>
          </ul>
      </li>
        @endif

      <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Shipping Charges</span> <span class="label label-important">2</span></a>
          <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display: block;" <?php } ?>>
              <li <?php if (preg_match("/view-shipping/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-shipping')}}">View Shipping Charges</a></li>
          </ul>
      </li>
  </ul>
</div>
<!--sidebar-menu-->
