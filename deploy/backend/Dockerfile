FROM php:7.3-fpm-alpine3.8

RUN rm -f /etc/apk/repositories &&\
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.8/main" >> /etc/apk/repositories && \
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.8/community" >> /etc/apk/repositories

RUN apk add --no-cache --virtual .build-deps  \
    zlib-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    bzip2-dev \
    postgresql-dev


RUN apk add --update --no-cache \
    jpegoptim \
    pngquant \
    optipng \
    supervisor \
    nano \
    icu-dev \
    freetype-dev \
    libzip-dev

RUN docker-php-ext-configure \
    opcache --enable-opcache &&\
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ &&\
    docker-php-ext-install \
    opcache \
    pdo_pgsql \
    pgsql \
    pdo \
    sockets \
    json \
    intl \
    gd \
    xml \
    zip \
    bz2 \
    pcntl \
    bcmath

RUN echo '*  *  *  *  * /usr/local/bin/php  /var/www/backend/artisan schedule:run >> /dev/null 2>&1' > /etc/crontabs/root && mkdir /etc/supervisor.d

RUN apk del -f .build-deps

WORKDIR /var/www/backend

COPY . /var/www/backend

RUN chown -R www-data:www-data \
    /var/www/backend/storage \
    /var/www/backend/bootstrap/cache && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --no-scripts --no-interaction --ignore-platform-reqs

EXPOSE 9000
CMD ["php-fpm"]
