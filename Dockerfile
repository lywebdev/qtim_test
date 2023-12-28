FROM php:8.2-apache

WORKDIR /var/www/html

COPY . /var/www/html

RUN apt-get update && apt-get install -y \
    libicu-dev libonig-dev \
    && docker-php-ext-install -j$(nproc) intl mbstring

RUN apt-get install -y unzip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Копируем файл composer.json и composer.lock в образ
COPY composer.json composer.lock ./

# Удаляем папку vendor
RUN rm -rf vendor

# Удаляем файл psalm.xml
RUN rm -f psalm.xml

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

# Очищаем кэш Composer
RUN composer clear-cache

RUN a2enmod rewrite

RUN composer clear-cache
RUN composer install --no-interaction --optimize-autoloader --ignore-platform-reqs

CMD ["apache2-foreground"]