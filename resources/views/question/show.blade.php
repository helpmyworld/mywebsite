@extends('layouts.frontLayout.front_design')

<?php $titleTag = htmlspecialchars($post->title); ?>

@section('title', "| $titleTag")





@section('content')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="blog-post-area">
                        <h2 class="title text-center">Latest From Questions</h2>
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
                            </div>
                    </div>
                    <br>
                    <div class="rating-area">
                        <ul class="ratings">
                            <li class="rate-this">COMMENTS:</li>
                            <li class="color">{{ $post->comments()->count() }} Comments</li>
                        </ul>

                    </div><!--/rating-area-->
                    <div class="media commnets">
                        @foreach($post->comments as $comment)
                            <a class="pull-left" href="#">
                                <img class="media-object" src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?s=50&d=monsterid" }}" alt="">
                            </a>
                            <div class="media-body">
                                <ul class="sinlge-post-meta">
                                    <li><i class="fa fa-user"></i>{{ $comment->name }}</li>
                                    <li><i class="fa fa-calendar"></i>{{ date('F dS, Y - g:iA' ,strtotime($comment->created_at)) }}</li>
                                </ul>
                                <h4 class="media-heading"> </h4>
                                <p>{{ $comment->comment }}</p>
                            </div>
                        @endforeach

                            <div class="replay-box">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h2>Leave a comment</h2>
                                        {{ Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST']) }}

                                        <div class="row">
                                            <div class="col-md-6">
                                                {{ Form::label('name', "Name:") }}
                                                {{ Form::text('name', null, ['class' => 'form-control']) }}
                                            </div>

                                            <div class="col-md-6">
                                                {{ Form::label('email', 'Email:') }}
                                                {{ Form::text('email', null, ['class' => 'form-control']) }}
                                            </div>

                                            <div class="col-md-12">
                                                {{ Form::label('comment', "Comment:") }}
                                                {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

                                                {{ Form::submit('Add Comment', ['class' => 'btn btn-primary btn-block', 'style' => 'margin-top:15px;']) }}

                                            </div>
                                        </div>

                                        {{ Form::close() }}
                                    </div>

                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

