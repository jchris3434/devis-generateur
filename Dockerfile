FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    nodejs \
    npm \
    git \
    && docker-php-ext-install pdo pdo_mysql gd xml opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && echo "opcache.enable=1" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.memory_consumption=128" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.interned_strings_buffer=8" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.max_accelerated_files=4000" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.revalidate_freq=2" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.fast_shutdown=1" >> "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Install and compile frontend assets
RUN npm ci && npm run build

# Set correct permissions
RUN chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Generate application key if not exists
RUN php artisan key:generate --force

EXPOSE 8974

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8974"]
