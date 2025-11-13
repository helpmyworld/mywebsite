@extends('layouts.master')

@section('title', '| All Posts')

@section('content')
<div class="container">
		<div class="col-md-9">
			<h1>All Posts</h1>
		</div>

	<!-- end of .row -->

	<div class="row">
		<div class="col-md-10">
			<div class="col-md-6 col-md-offset-2">
				<a href="{{ route('writers.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create New Profile</a>
			</div>
			<table class="table">
				<thead>
					<th>#</th>
					<th>Name</th>
					<th>Authors Profile</th>
					<th>Created At</th>
					<th></th>
				</thead>

				<tbody>
					
					@foreach ($writers as $writer)
						
						<tr>
							<th>{{  $writer->id }}</th>
							<td>{{  $writer->title }}</td>
							<td>{{ substr(strip_tags( $writer->body), 0, 50) }}{{ strlen(strip_tags( $writer->body)) > 50 ? "..." : "" }}</td>
							<td>{{ date('M j, Y', strtotime( $writer->created_at)) }}</td>
							<td><a href="{{ route('writers.show',  $writer->id) }}" class="btn btn-default btn-sm">View</a>
								<a href="{{ route('writers.edit',  $writer->id) }}" class="btn btn-default btn-sm">Edit</a></td>
						</tr>

					@endforeach

				</tbody>
			</table>

			{{--<div class="text-center">--}}
				{{--{!!  $writer->links(); !!}--}}
			{{--</div>--}}
		</div>
	</div>

</div>
@stop