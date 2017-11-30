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
            <nav class="navbar-light bg-light"
                v-bind:class="{ sepia: sepia, dark: dark }">
                <div class="container">@include('components.nav')</div>
            </nav>
            <main class="container animation"
                v-bind:class="{ sepia: sepia, dark: dark }"
                style="margin-top: 15px;">
                @if (!empty($links = breadcrumb()))
                <div class="row">
                    <div class="custom-breadcrumb col text-right">
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
                </div>
                @endif
                <div class="row">
<!--                     <div class="reading-mode-buttons center-block text-center row">
                    @include('components.readerModeButtons')
                    <br />
                    </div> -->
                    @yield('content')
                </div>
            </main>
            <footer class="footer">
                <div class="footer-overlay">
                    <div class="container row mx-auto">
                        <div class="col-12 text-center">
                            <h6>ما را دنبال کنید</h6>
                            <span><a href="https://t.me/negarin_telegram"><i class="fa fa-telegram fa-fw" aria-hidden="true"></i></a></span>
                            <hr />
                        </div>
                        <div class="col-12 text-center">
                            <span>
                            <a href="{{ url('/') }}">
                                <img src="{{ secure_asset('images/logo.png') }}"
                                    alt="{{ config('app.name', 'Negar') }}"
                                    style="width: 28px;"
                                    title="{{ config('app.name', 'Negar') }}"
                                    data-pagespeed-no-transform/>
                            </a>
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
