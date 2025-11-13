@if(Session::has('success'))
<div class="alert alert-success" role="success">
    <strong>Great! </strong>{{Session::get('success')}}
</div>
@endif

@if(count($errors)>0)
<div class="alert alert-success" role="success">
    <strong>Damn! something went wrong.</strong>
    <ul>
        @foreach($errors as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif