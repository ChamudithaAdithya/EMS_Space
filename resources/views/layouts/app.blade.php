<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{--page title--}}
    <title>
        @yield('title')
    </title>
    {{--styles--}}
    @include('libraries.styles')
    {{--scripts--}}
    @include('libraries.scripts')
</head>
   {{-- <body style="background-color: #ffffff">  --}}
   {{-- <body style="background: linear-gradient(to bottom, #BBFFFB 10%, #FFFFFF 19%, #FFFFFF 85%, #B1EBE8 100%);"> --}}
   {{-- <body class="vh-100" style="background-image: url('{{ asset('images/image5.jpeg') }}');"> --}}

    {{--page nav bar--}}
    @include('components.nav')
    {{--content of page--}}
    @yield('content')
    {{--page footer--}}
    @include('components.footer')

</body>
</html>
