@extends('admin.layout.admin')


@section('stylesheets')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}

    <link href="...js/select2.min.css" rel="stylesheet"/>

@endsection
@section('content')
    <div class="container">
        <div class="col-md-8">
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
                <div class="page_header_wrap">
                    <div class="page_header">
                        <h2>UPDATE AUTHOR'S PROFILE</h2>
                    </div>
                </div>
                <div class="row"
                <div class="col-md-8 col-md-offset-0">
                    <div class="panel-body">
                        <form class="form-horizontal"  method="post" action="
                {{route('writer', $writer->id)}}" enctype="multipart/form=data">
                            {{method_field('PUT')}}{{csrf_field()}}

                            <div class="form-group {{$errors->has('title')?'has-error':''}}">
                                <label class="col-md-4 control-label" for="title">Title:</label>
                                <div class="col-md-6">
                                    <input type="text" name="title" id="title" class="form-control" value="{{$writer->title}}" required>
                                    @if($errors->has('title'))
                                        <span class="help-block">
                                <strong>{{$errors->first('title')}}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{$errors->has('slug')?'has-error':''}}">
                                <label class="col-md-2 control-label" for="Slug">Slug:</label>
                                <div class="col-md-8 col-md-offset-0">
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{old('slug')}}" required>
                                    @if($errors->has('slug'))
                                        <span class="help-block">
                                <strong>{{$errors->first('slug')}}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>

                            {{--<div class="form-group {{$errors->has('tags')?'has-error':''}}">--}}
                                {{--<label class="col-md-2 control-label" for="tags">Tags:</label>--}}
                                {{--<div class="col-md-8 col-md-offset-0">--}}

                                    {{--<select class="form-control select2-multi" name="tags" id="tags"  multiple="multiple">--}}
                                        {{--@foreach($tags as $tag)--}}
                                            {{--<option value="{{$tag->id}}">{{$tag->name}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}

                                    {{--@if($errors->has('tags'))--}}
                                        {{--<span class="help-block">--}}
                                {{--<strong>{{$errors->first('tags')}}</strong>--}}
                            {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group {{$errors->has('categories')?'has-error':''}}">--}}
                                {{--<label class="col-md-2 control-label" for="categories">Categories:</label>--}}
                                {{--<div class="col-md-8 col-md-offset-0">--}}
                                    {{--{{ Form::select('category_id', $categories, null, ['class' => 'form-control','placeholder'=>'Select Category']) }}--}}
                                    {{--<select class="form-control select2-multi" id="categories" name="categories"  multiple="multiple">--}}
                                        {{--@foreach($categories as $category)--}}
                                            {{--<option value="{{$category->id}}">{{$category->name}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                    {{--@if($errors->has('category_post'))--}}
                                        {{--<span class="help-block">--}}
                                {{--<strong>{{$errors->first('categories')}}</strong>--}}
                            {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group {{$errors->has('image')?'has-error':''}}">
                                <label class="col-md-2 control-label" for="image">Upload Image:</label>
                                <div class="col-md-8 col-md-offset-0">
                                    <input type ="file" name="image" id="image" class="form-control"  multiple="multiple">

                                </div>
                            </div>

                            <div class="form-group {{$errors->has('body')?'has-error':''}}">
                                <label class="col-md-6 control-label" for="body">Author's Profile:</label>
                                <div class="col-md-12 col-md-offset-0">
                                    <textarea id="body" name="body" class="form-control" no validate></textarea>
                                    @if($errors->has('body'))
                                        <span class="help-block">
                                <strong>{{$errors->first('body')}}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>




                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-success btn-block">
                                        Update Profile
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <a href="{{route('writers.show',$writer->id)}}" class="btn btn-danger btn-block">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section ('scripts')
    <script src=".../js/query-3.2.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



    <script src="/files/js/parsley.min.js"></script>
    <script src="/files/js/select2.min.js"></script>

    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>


    <script src="/files/tinymce/tinymce.min.js"></script>
    {{--<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>--}}
    <script>
        tinymce.init({
            selector: '#body'
//            plugins: '#link code',
//            menubar: false

        });
    </script>


@endsection
