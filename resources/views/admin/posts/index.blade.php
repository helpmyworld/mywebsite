@extends('layouts.adminLayout.admin_design')
@section('content')

    <link rel="stylesheet" href="/public/css/select2.min.css"> <!-- note leading / -->
    <link rel="stylesheet" href="/public/css/parsley.css">




@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Posts</a> <a href="#" class="current">Add Product</a> </div>
            <h1>Posts</h1>
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
        </div>

        <div class="container">
            <div class="col-md-12">
                <div class="well">
                    <div class="alert-warning">
                        @foreach( $errors->all() as $error )
                            <br> {{ $error }}
                        @endforeach
                        @if(Session::has('flash_message'))
                            <div class="alert alert-success">
                                {{ Session::get('flash_message') }}
                            </div>
                        @endif
                    </div>
        <hr>

                    <div class="col-md-6 col-md-offset-2">
                        <a href="{{ route('posts.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create New Post</a>
                    </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>All Posts</h5>
        </div>

        <div class="widget-content nopadding">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>

                        <th>Id</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>created</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)
                        <tr class="gradeA">
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ substr(strip_tags($post->body), 0, 50) }}{{ strlen(strip_tags($post->body)) > 50 ? "..." : "" }}</td>
                            <td>{{ date('M j, Y', strtotime($post->created_at)) }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-default btn-sm">View</a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-default btn-sm">Edit</a>

                                @if($post->approved == true)
                                    <a href="{{ route('admin.posts.disapprove', $post->id) }}" class="btn btn-default btn-sm">Disapprove</a>
                                @else
                                    <a href="{{ route('admin.posts.approve', $post->id) }}" class="btn btn-default btn-sm">Approve</a>
                                @endif

                                {{-- ✅ One-click Delete (destroy) --}}
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                    {{--{!! $posts->links(); !!}--}}
                </table>
            </div>

        </div>
    </div>


@stop
