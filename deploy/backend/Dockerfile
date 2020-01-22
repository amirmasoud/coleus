FROM php:${FPM_VERSION}

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/backend/

# Set working directory
WORKDIR /var/www/backend

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    postgresql-client \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
# COPY . /var/www/backend

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/backend

RUN chown root:root /var/www && \
    chmod 755 /var/www/ && \
    chown -R www:www /var/www/backend && \
    chmod -R 774 /var/www/backend

# Change current user to www
USER www

RUN composer install --no-dev --no-interaction --ignore-platform-reqs

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
