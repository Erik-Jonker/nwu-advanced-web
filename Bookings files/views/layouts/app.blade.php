<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
  {{-- IF USER IS LOGGED IN, SHOW NAVBAR, ELSE, ADD A FEW BREAKS TO THE TOP TO COMPENSATE FOR THE NAV BAR --}}
   @if(Auth::check())
     @include('layouts.navbar')
   @else
     <br><br>
     <br><br>
   @endif

    <div id="app">
        @yield('vuecontent')
    </div>

    @yield('content')

    @if(Auth::check())
      @include('layouts.authfooter')
    @else
      @include('layouts.footer')
    @endif
</body>
</html>
