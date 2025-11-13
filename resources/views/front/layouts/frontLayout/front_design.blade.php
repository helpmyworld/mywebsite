<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta property="fb:app_id" content="1142473855887730" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image:alt" content="" />

    <title>@if(!empty($meta_title)){{$meta_title}}@else Helpmyworld  @endif </title>
    @if(!empty($meta_description))<meta name="description" content="{{$meta_description}}">@endif
    @if(!empty($meta_keywords))<meta name="keywords" content="{{$meta_keywords}}">@endif
   {{-- <link href="{{ asset('/public/css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('/css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    {{--<link href="{{ asset('/public/css/frontend_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/css/frontend_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/css/frontend_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/css/frontend_css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('/public/css/frontend_css/main.css') }}" rel="stylesheet">
	<link href="{{ asset('/public/css/frontend_css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/css/frontend_css/easyzoom.css') }}" rel="stylesheet">
    <link href="{{ asset('/public/css/frontend_css/passtrength.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('/css/frontend_css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/frontend_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/frontend_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/frontend_css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/frontend_css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/frontend_css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/frontend_css/easyzoom.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/frontend_css/passtrength.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/public/js/html5shiv.js"></script>
    <script src="/public/js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59a849469602dc83"></script>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122580378-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-122580378-1');
    </script>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135436293-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-135436293-1');
    </script>


    
    <link rel="shortcut icon" type="image/x-icon" href="/public/images/icon.png" />
</head><!--/head-->

<body>
	@include('layouts.frontLayout.front_header')
	
	@yield('content')
	
	@include('layouts.frontLayout.front_footer')

    {{--<script src="{{ asset('/public/js/frontend_js/jquery.js') }}"></script>
	<script src="{{ asset('/public/js/frontend_js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/public/js/frontend_js/jquery.scrollUp.min.js') }}"></script>
	<script src="{{ asset('/public/js/frontend_js/price-range.js') }}"></script>
    <script src="{{ asset('/public/js/frontend_js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('/public/js/frontend_js/easyzoom.js') }}"></script>
    <script src="{{ asset('/public/js/frontend_js/main.js') }}"></script>
    <script src="{{ asset('/public/js/frontend_js/jquery.validate.js') }}"></script>
    <script src="{{ asset('/public/js/frontend_js/passtrength.js') }}"></script>
    <script src="{{ asset('/public/js/frontend_js/md5/md5-min.js') }}"></script>--}}
    <script src="{{ asset('/js/frontend_js/jquery.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/jquery.scrollUp.min.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/price-range.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/jquery.prettyPhoto.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/easyzoom.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/main.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/jquery.validate.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/passtrength.js') }}"></script>
  <script src="{{ asset('/js/frontend_js/md5/md5-min.js') }}"></script>


    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.js"></script>--}}

    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=sryrxbg06q9852su2mjg2y4spjvfzs0c56o8rzptnk3oq1tz"></script>

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.js"></script>--}}
    {{--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>--}}
    
    <script>
        $(function(){
            $("#expiry_date").datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

    
</body>

</html>
