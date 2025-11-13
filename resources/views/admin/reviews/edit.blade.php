@extends('admin.layout.admin')

@section('title', '| Edit Review')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Edit Review</h1>
			
			{{ Form::model($review, ['route' => ['reviews.update', $review->id], 'method' => 'PUT']) }}
			
				{{ Form::label('name', 'Name:') }}
				{{ Form::text('name', null, ['class' => 'form-control', 'disabled' => '']) }}
			
				{{ Form::label('email', 'Email:') }}
				{{ Form::text('email', null, ['class' => 'form-control', 'disabled' => '']) }}
			
				{{ Form::label('review', 'Review:') }}
				{{ Form::textarea('review', null, ['class' => 'form-control']) }}
			
				{{ Form::submit('Update Review', ['class' => 'btn btn-block btn-success', 'style' => 'margin-top: 15px;']) }}
			
			{{ Form::close() }}
		</div>
	</div>

@endsection