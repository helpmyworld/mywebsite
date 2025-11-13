 <div class="single-blog-post">
            <div class="post-meta">
                <ul>
                    <li><i class="fa fa-user"></i>  @if($post->user) By {{$post->user->name}} @else By Rorisang Dawn Maimane @endif</li>
                    <li><i class="fa fa-clock-o"></i> {{$post->created_at->toFormattedDateString()}}</li>
                    <li><i class="fa fa-calendar"></i> </li>
                </ul>
                <span>
									<!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox_e4f5"></div>
								</span>
            </div>

            <p>{!! substr($post->body,0,500)!!}{{strlen($post->body)>500?"...":""}}</p>
            <a href="{{route('questions.show', $post->slug)}}"></a>
            <a  class="btn btn-primary" href="{{route('questions.show', $post->slug)}}">Read More</a>
            <br>
            <br>
    </div>
