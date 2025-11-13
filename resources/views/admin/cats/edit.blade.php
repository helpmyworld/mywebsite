@extends('admin.layout.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    <h3>Update Category</h3>
                    <hr>
                    <form class="form-horizontal" role="form" method="post" action="{{route('categories.update')}}">
                        {{method_field('PUT')}} {{csrf_field()}}

                        <div class="form-group {{$errors->has('name')?'has-error':''}}">
                            <label for="name" class="col-sm-6 control-label">Category Name:</label>
                            <div class="col-md-6">
                                <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}"
                                       required placeholder="{{$category->name}}">
                                @if($errors->has('name'))
                                    <span class="help-block">
                            <strong>{{$errors->first('name')}}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block">Update Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



@stop