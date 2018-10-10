<div class="content">
    <div class="title">Something went wrong.</div>

    @if(app()->bound('sentry') && !empty(Sentry::getLastEventID()))
        <div class="subtitle">Error ID: {{ Sentry::getLastEventID() }}</div>

        <!-- Sentry JS SDK 2.1.+ required -->
        <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

        <script>
            Raven.showReportDialog({
                eventId: '{{ Sentry::getLastEventID() }}',
                // use the public DSN (dont include your secret!)
                dsn: 'https://9ffba6f702af4d07a23c86bfb761f0d2@sentry.io/1297182',
                user: {
                    'name': "{{ Auth::check() ? Auth::user()->name : 'Jane Doe' }}",
                    'email': "{{ Auth::check() ? Auth::user()->email : 'jane.doe@example.com' }}",
                }
            });
            @auth
            Sentry.configureScope((scope) => {
                scope.setUser({
                    "id": "{{ Auth::user()->id }}",
                    "email": "{{ Auth::user()->email }}",
                    "ip_address": "{{ request()->ip() }}",
                    "geoip": "{{ json_encode(geoip(request()->ip())->toArray()) }}"
                });
            });
            @endauth
        </script>
    @endif
</div>