FROM php:7.1
RUN apt-get update -y && \
    apt-get install -y curl vim && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
