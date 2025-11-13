@extends('layouts.frontLayout.front_design')


@section('title', 'blog')

@section('content')

    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-12">
                    <div class="blog-post-area">
                        <h2 class="title text-center">Latest From Questions</h2>
                        <div class="single-blog-post">
                            @if ($posts->count())
                                @foreach($posts as $post)
                                    @include('partials.question')
                                @endforeach
                            @else
                                <div class="jumbotron">
                                    <p>No Questions, Please Visit Later.</p>
                                    <br> <br>
                                    <p>You must be a user to be able to ask questions.</p>
                                </div>
                            @endif

                            <div class="text-center">
                                {!!$posts->links()!!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
