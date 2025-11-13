{{-- resources/views/layouts/frontLayout/front_sidebar.blade.php --}}


<div class="single-block">
    <h3 class="sidebar-title">Categories</h3>
    @foreach($categories as $cat)
    <ul class="sidebar-menu--shop">
    
            <ul class="inner-cat-items">
                @foreach($cat->categories as $subcat)
                    @if($subcat->status==1)
                    <li><a href="{{ asset('products/'.$subcat->url) }}">{{$subcat->name}} </a></li>
                    @endif
                @endforeach
            </ul>
           </ul>
    @endforeach
</div>                             


