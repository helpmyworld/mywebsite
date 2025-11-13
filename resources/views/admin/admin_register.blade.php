<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>E-commerce Admin</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="{{ asset('/css/backend_css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('/css/backend_css/bootstrap-responsive.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('/css/backend_css/matrix-login.css') }}" />
        <link href="{{ asset('/fonts/backend_fonts/css/font-awesome.css') }}" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">    
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

            <form id="registerForm" name="registerForm" action="{{ url('/admin-register') }}" method="POST">{{ csrf_field() }}
                <input id="usrname" name="username" type="text" placeholder="Username"/>
                {{--<input id="email" name="email" type="email" placeholder="Email Address"/>--}}
                <input id="myPassword" name="password" type="password" placeholder="Password"/>
                <button type="submit" class="btn btn-default">Signup</button>
            </form>


        </div>
        
        <script src="{{ asset('/js/backend_js/jquery.min.js') }}"></script>  
        <script src="{{ asset('/js/backend_js/matrix.login.js') }}"></script> 
        <script src="{{ asset('/js/backend_js/bootstrap.min.js') }} "></script> 
    </body>

</html>
