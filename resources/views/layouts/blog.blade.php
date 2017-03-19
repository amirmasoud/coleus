<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script>
        window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        ]) !!};
        </script>
    </head>
    <body>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                @include('components.nav')
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @yield('content')
                </div>
                <div class="col-md-3">
                    @include('components.sidebar')
                </div>
            </div>
        </div>
        <hr>
        @include('components.footer')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>