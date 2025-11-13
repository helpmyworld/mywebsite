


<div class="row">
    <div class="col-md-4">
        <div class="thumbnail">


        <a href="/author/{{$author->id}} {{$author->title}}"><div class="product-grid love-grid">
            <div class="more-product"><span> </span></div>
            <div class="product-img b-link-stripe b-animate-go  thickbox">
                @if(!empty($author->image))
                    <img src="{{asset('/images/' . $author->image)}}"  class="img-responsive" alt="" width="250" height="350" />
                @endif
                    <div class="b-wrapper">
                        <h4 class="b-animate b-from-left  b-delay03">
                            <button class="btns"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Quick View</button>
                        </h4>
                    </div>
            </div>

            <p style="text-align: justify">{!! substr($author->body,0,150)!!}{{strlen($author->body)>500?"...":""}}</p>

            </div>
        </a>
        </div>
    </div>
</div>




