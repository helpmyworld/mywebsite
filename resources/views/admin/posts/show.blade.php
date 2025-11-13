@extends('layouts.adminLayout.admin_design')
@section('content')

    <div id="content">

            @if(Session::has('flash_message_error'))
                <div class="alert alert-error alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif


        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Postss</a>
                <a href="#" class="current">Post</a> </div>
            <h1>Post</h1>
        </div>
        <div class="container-fluid"><hr>
            <div class="row-fluid">
                <div class="span12">
                    @if($post != null)
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
                            <h5 >{{$post->title}}

                            </h5>
                        </div>
                        <div class="widget-content">
                            <div class="row-fluid">

                                <div class="span12">
                                    <table class="table table-bordered table-invoice">
                                        <tbody>
                                        <tr>
                                        <tr>
                                            <td class="width30">Title:</td>
                                            <td class="width70"><strong>{{$post->title}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Slug:</td>
                                            <td><strong><a href="{{ route('blog.single', $post->slug) }}">{{ route('blog.single', $post->slug) }}</a></strong></td>
                                        </tr>
                                        <tr>
                                            <td>Created</td>
                                            <td><strong> By: Rorisang Maimane /Created:{{$post->created_at}}| Updated:{{$post->updated_at}}</strong></td>
                                        </tr>

                                        <tr>
                                        <td class="width30">Category:</td>
                                        <td class="width70">
                                            <strong>
                                                @foreach($post->cats as $cat)
                                                    <span class="label label-default"><a href="{{route('cats.show',
                                                     $cat->id)}}" style="color:white;">{{$cat->name}}</a></span>
                                                @endforeach
                                            </strong>
                                            <br>
                                        </td>
                                        </tr>
                                        <tr>

                                        <td class="width30">Tags:</td>
                                        <td class="width70">
                                            <strong>
                                                @foreach($post->tags as $tag)
                                                    <span class="label label-default"><a href="{{route('tags.show',
                                                             $tag->id)}}" style="color:white;">{{$tag->name}}</a></span>
                                                @endforeach
                                            </strong> <br>
                                        </td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <table class="table table-bordered table-invoice-full">
                                        <thead>
                                        <tr>

                                            <th class="head1"> Body</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>  {!! $post->body !!}</td>
                                        </tr>

                                        <tr>

                                            <th class="head1"> Edit Post</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>  <a href="#" class="btn btn-primary btn-mini">Edit</a></td>
                                        </tr>

                                        <tr>

                                            <th class="head1"> Delete Post</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'DELETE']) !!}

                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger ']) !!}

                                                {!! Form::close() !!}

                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-invoice-full">
                                        <tbody>
                                        <tr>
                                            <p>Comments <small>{{ $post->comments()->count() }} total</small></p>

                                            @foreach ($post->comments as $comment)
                                                {{ $comment->name }}
                                                {{ $comment->email }}
                                                {{ $comment->comment }}

                                                <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                            @endforeach


                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                        <a href="{{url('http://localhost:8000/posts')}}"><button class="btn btn-warning btn-mini">All Posts</button></a>
                </div>
            </div>
        </div>
    </div>



@stop
