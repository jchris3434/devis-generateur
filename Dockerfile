FROM php:8.2-fpm

# Installer les dépendances minimales
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install gd xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier uniquement les fichiers nécessaires
COPY composer.json composer.lock ./

COPY . .

RUN composer install --no-dev --optimize-autoloader



# Définir les permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
