<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>نگارین</title>
        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script>
        window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        ]) !!};
        </script>
        @if (env('APP_ENV') == 'production')
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-106052436-1', 'auto');
          ga('send', 'pageview');

        </script>
        @endif
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
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
