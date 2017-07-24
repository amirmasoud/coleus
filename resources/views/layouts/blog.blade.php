<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Negar') }}.{{ config('app.domain', 'in') }}</title>
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
        <div id="app">
            <div class="navbar navbar-default navbar-static-top">
                <div class="container">
                    @include('components.nav')
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @if (!empty($links = breadcrumb()))
                    <div class="custom-breadcrumb">
                        @foreach ($links as $link)
                        @if ($link['href'] == '#')
                        <strong><span>{{ $link['name'] }}</span></strong>
                        @else
                        <a href="{{ $link['href'] }}"><span>{!! $link['name'] !!}</span></a>
                        @endif
                        @unless ($link === end($links))
                        <i class="fa fa-angle-left separator"></i>
                        @endunless
                        @endforeach
                    </div>
                    @endif
                    @yield('content')
                </div>
            </div>
            @include('components.footer')
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>