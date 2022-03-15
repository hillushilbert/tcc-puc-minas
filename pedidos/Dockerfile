#docker login 
#docker build -t hillushilbert/app-pedidos:latest .
#docker push hillushilbert/app-pedidos:latest
#https://www.ti-enxame.com/pt/docker/executando-composer-instala-dentro-de-um-dockerfile/833985041/
FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
	libonig-dev \
    libxml2-dev \
    libzip-dev \
    libssl-dev \
    libjpeg62-turbo-dev \
    zip \
    # nodejs \
    # npm \
    sudo \
    libpq-dev

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && chmod +x /usr/local/bin/composer 

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-configure gd --with-jpeg 
# Install PHP extensions
RUN docker-php-ext-install pgsql pdo_pgsql mbstring exif pcntl bcmath gd soap zip sockets
#RUN pecl install xdebug
# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user && echo "$user:$user" | chpasswd && usermod -aG sudo $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /var/www && \
    touch /var/www/storage/logs/laravel.log && \
    chown -R $user:$user /var/www/storage && \
    chown -R $user:$user /var/www/bootstrap

# Set working directory
WORKDIR /var/www

COPY . .

USER $user

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8010
EXPOSE 8010