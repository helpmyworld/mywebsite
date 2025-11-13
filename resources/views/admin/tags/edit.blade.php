@extends('admin.layout.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="well">
                <h3>Update Tag</h3>
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
                <form class="form-horizontal" role="form" method="post" action="/tag/update/{{$tags->id}}">
                 {{csrf_field()}}
                
                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                    <label for="name" class="col-sm-6 control-label">Tag Name:</label>
                    <div class="col-md-6">
                        <input type="text" id="name" class="form-control" name="name" value="{{$tags->name}}"
                        required placeholder="{{$tags->name}}">
                        @if($errors->has('name'))
                        <span class="help-block">
                            <strong>{{$errors->first('name')}}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-block">Update Tag</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@stop