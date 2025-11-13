<?php $url = url()->current(); ?>
<aside class="left-sidebar" data-sidebarbg="skin5">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav" class="p-t-30">

        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link"
             href="{{ route('author.dashboard') }}" aria-expanded="false">
            <i class="mdi mdi-view-dashboard"></i>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link has-arrow waves-effect waves-dark"
             href="{{ route('author.manuscripts.index') }}" aria-expanded="false">
            <i class="mdi mdi-receipt"></i>
            <span class="hide-menu">Manuscript </span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
              <a href="{{ route('author.manuscripts.index') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> View </span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('author.manuscripts.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-plus"></i>
                <span class="hide-menu"> Upload </span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('author.orders.index') }}" class="sidebar-link">
                <i class="mdi mdi-note-plus"></i>
                <span class="hide-menu"> My Orders </span>
              </a>
            </li>
          </ul>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link has-arrow waves-effect waves-dark"
             href="{{ route('author.manuscripts.index') }}" aria-expanded="false">
            <i class="mdi mdi-receipt"></i>
            <span class="hide-menu">Subscription </span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
              <a href="{{ route('author.subscriptions.index') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> My Subscription Benefits View </span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('author.subscriptions.browse') }}" class="sidebar-link">
                <i class="mdi mdi-note-plus"></i>
                <span class="hide-menu"> Subscribe/Join Us </span>
              </a>
            </li>
          </ul>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link has-arrow waves-effect waves-dark"
             href="{{ route('author.manuscripts.index') }}" aria-expanded="false">
            <i class="mdi mdi-cart"></i>
            <span class="hide-menu">Reports: Product & Orders</span>
          </a>

          <!-- NEW: Reports (after Product & Orders, before Sales) -->
        <li class="sidebar-item {{ request()->routeIs('author.sales.*') ? 'selected' : '' }}">
          <a class="sidebar-link waves-effect waves-dark sidebar-link"
             href="{{ route('author.sales.index') }}" aria-expanded="false">
            <i class="mdi mdi-bank-transfer"></i>
            <span class="hide-menu">Reports / Sales</span>
          </a>
        </li>

          

          <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
              <a href="{{ route('author.products.index') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> View </span>
              </a>
            </li>
      
            <li class="sidebar-item">
              <a href="{{ route('author.products.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-plus"></i>
                <span class="hide-menu"> Add </span>
              </a>
            </li>
          </ul>
        </li>

        <!-- NEW: Payouts (after Product & Orders, before Sales) -->
        <li class="sidebar-item {{ request()->routeIs('author.payouts.*') ? 'selected' : '' }}">
          <a class="sidebar-link waves-effect waves-dark sidebar-link"
             href="{{ route('author.payouts.index') }}" aria-expanded="false">
            <i class="mdi mdi-bank-transfer"></i>
            <span class="hide-menu">Payouts</span>
          </a>
        </li>
        <!-- /NEW: Payouts -->

        <!-- Sales -->
     

        <li class="nav-item">
          <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"></a>
          <a href="" class="btn btn-success">
            <i class="mdi mdi-cash-multiple"></i> Premium Members Benefits
          </a>
        </li>

        @foreach(\App\Subscription::where('title','Indie.Africa')->first()->benefits as $benefit)
          @if(auth()->user()->premium_subscription())
            <li class="sidebar-item">
              <a href="javascript:;" class="sidebar-link">
                <i class="mdi mdi-check"></i>
                <span class="hide-menu"> {{ $benefit->name }} </span>
              </a>
            </li>
          @else
            <li class="sidebar-item">
              <a href="javascript:;" class="sidebar-link" disabled>
                <i class="mdi mdi-lock-outline"></i>
                <span class="hide-menu"> {{ $benefit->name }} </span>
              </a>
            </li>
          @endif
        @endforeach

      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>

<!--sidebar-menu-->
