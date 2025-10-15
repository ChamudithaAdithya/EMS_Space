<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--page title--}}

    {{--styles--}}
    @include('libraries.styles')
</head>
   {{-- <body style="background-color: #122195">  --}}
   {{-- <body class="vh-100" style="background-image: url('{{ asset('images/image5.jpeg') }}');"> --}}
    {{-- <body style="background: linear-gradient(to bottom, #BBFFFB 10%, #FFFFFF 19%, #FFFFFF 85%, #B1EBE8 100%);"> --}}
    {{--page nav bar--}}

    {{--content of page--}}
    @yield('content')
    {{--page footer--}}

    {{--scripts--}}
    @include('libraries.scripts')
</body>
</html>
