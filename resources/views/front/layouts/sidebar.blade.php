
<div class="left-sidebar">
    <h2>Category</h2>

    <div class="panel-group category-products" id="accordian">
        <!--category-products-->
        @foreach($cats as $cat)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="/posts/cats/{{$cat}}">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            {{$cat}}
                        </a>
                    </h4>
                </div>
            </div>
        @endforeach
    </div>

</div>


<!-- Categories List End -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad -->
<ins class="adsbygoogle"
     style="display:inline-block;width:160px;height:600px"
     data-ad-client="ca-pub-1026112827105560"
     data-ad-slot="6196006486"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
            




