
    <div class="single-blog-post">
        <a href="{{route('blog.single', $post->slug)}}"><h3>{{$post->title}}</h3>
        <div class="post-meta">
            <ul>
                <li><i class="fa fa-user"></i>  @if($post->user) By {{$post->user->name}} @else {{$post->admin->username}} @endif </li>
                <li><i class="fa fa-clock-o"></i> {{$post->created_at->toFormattedDateString()}}</li>
                <li><i class="fa fa-calendar"></i> </li>
            </ul>
            <span>
									<!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox_e4f5"></div>
								</span>
        </div>
        <a href="">
            @if(!empty($post->image))
                <img src="{{asset('/images/' . $post->image)}}" width="700" height="450" />
            @endif
        </a>
        <p>{!! substr($post->body,0,500)!!}{{strlen($post->body)>500?"...":""}}</p>
        <a href="{{route('blog.single', $post->slug)}}"></a>
        <a  class="btn btn-primary" href="{{route('blog.single', $post->slug)}}">Read More</a>
    </div>
