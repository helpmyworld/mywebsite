<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Helpmyworld Publishing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Use Minified Plugins Version For Fast Page Load -->
     <link href="{{ asset('/frontend/css/plugins.css') }}" rel="stylesheet">
        <link href="{{ asset('/frontend/css/main.css') }}" rel="stylesheet">
        <link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico">
<link rel="preconnect" href="https://challenges.cloudflare.com">
        <script src="https://cdn.tiny.cloud/1/hkeugakcjabj5i5crwz4uwobvp2y9eca01mgcihlc4227utv/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

</head>

<body>

 {{-- Header --}}
    @include('layouts.frontLayout.front_header')

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('layouts.frontLayout.front_footer')

    


   <!-- Use Minified Plugins Version For Fast Page Load -->
   <script src="{{ asset('/frontend/js/plugins.js') }}" defer></script>
   <script src="{{ asset('/frontend/js/ajax-mail.js') }}" defer></script>
   <script src="{{ asset('/frontend/js/custom.js') }}" defer></script>
</body>
</html>