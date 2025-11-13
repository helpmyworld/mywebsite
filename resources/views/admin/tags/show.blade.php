@extends('admin.layout.admin')

@section('content')
<div class="container">
    @if($tag != null)
    <div class="row">

        <div class="col-md-6">


            <h1>Tag | <strong>{{$tag->name}}</strong></h1>
            <span><a href="{{route('tags.edit', ['id'=>$tag->id])}}" class="btn btn-primary">Edit Tag</a></span>
            <span>
                <a href="/tag/{{$tag->id}}" class="btn btn-danger">Delete</a>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Tag <b>{{$tag->name}}</b><small> Is In <strong style="color:red;">
                    {{$tag->posts()->count()}}</strong>Posts</small></h2>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Post Name</th>
                        <th>Links</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tag->posts as $tag)
                    <tr>
                        <th>{{$tag->title}}</th>
                        <th><a href="{{route('slug', $tag->slug)}}" class="btn btn-info btn-lg">Go To Post</a></th>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
        @endif
</div> 

@endsection
