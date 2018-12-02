@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
    'googleAuth' => config('services.google.client_id')
];

$polyfills = [
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith',
    'IntersectionObserver'
];
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#343a40">
  <link rel="icon" sizes="192x192" href="/images/logo-192x192.png">

  <link rel="dns-prefetch" href="//negar.in">

  <title>{{ __('general.negarin') }}</title>

  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="manifest" href="/manifest.json">
  <link rel="icon" sizes="32x32" href="/images/favicon-32x32.png">
  <link rel="icon" sizes="192x192" href="/images/touch-icon-192x192.png">
  <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon-180x180-precomposed.png">
  @unless(app()->isLocal())
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106052436-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-106052436-1');
  </script>
  @endunless

</head>
<body>
  <div id="app"></div>

  {{-- Global configuration object --}}
  <script>window.config = @json($config);</script>

  {{-- Polyfill JS features via polyfill.io --}}
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>

  {{-- Load the application scripts --}}
  @if (app()->isLocal())
    <script src="{{ mix('js/app.js') }}"></script>
  @else
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
  @endif
</body>
</html>
