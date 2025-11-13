<?php $url = url()->current(); ?>
<aside class="left-sidebar" data-sidebarbg="skin5">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav" class="p-t-30">
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('author.dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="{{route('author.manuscripts.index')}}" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Manuscript </span></a>
          <ul aria-expanded="false" class="collapse  first-level">
            <li class="sidebar-item"><a href="{{route('author.manuscripts.index')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> View </span></a></li>
            <li class="sidebar-item"><a href="{{route('author.manuscripts.create')}}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Upload </span></a></li>
            <li class="sidebar-item"><a href="{{route('author.orders.index')}}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> My Orders </span></a></li>
          </ul>
        </li>
        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="{{route('author.manuscripts.index')}}" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Subscription </span></a>
          <ul aria-expanded="false" class="collapse  first-level">
            <li class="sidebar-item"><a href="{{route('author.subscriptions.index')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> My Subscription Benefits View </span></a></li>
            <li class="sidebar-item"><a href="{{route('author.subscriptions.browse')}}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Subscribe/Join Us </span></a></li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>

<!--sidebar-menu-->
