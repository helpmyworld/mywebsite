@extends('admin.layout.admin')

@section('title', '| DELETE REVIEW?')

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>DELETE THIS REVIEW?</h1>
			<p>
				<strong>Name:</strong> {{ $review->name }}<br>
				<strong>Email:</strong> {{ $review->email }}<br>
				<strong>Review:</strong> {{ $review->review }}
			</p>

			{{ Form::open(['route' => ['reviews.destroy', $review->id], 'method' => 'DELETE']) }}
				{{ Form::submit('YES DELETE THIS REVIEW', ['class' => 'btn btn-lg btn-block btn-danger']) }}
			{{ Form::close() }}
		</div>
	</div>

@endsection