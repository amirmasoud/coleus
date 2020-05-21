#!/usr/bin/env sh

set -e

php artisan queue:work --verbose --tries=3 --timeout=90 &

* * * * * php artisan schedule:run >>/dev/null 2>&1

exec php-fpm
