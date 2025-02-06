FROM php:8.4-fpm

# Instalar dependencias del sistema y utilidades
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    unzip \
    curl

# Instalar Node.js (en este ejemplo, se usa la versión 18.x)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Configurar la extensión GD para PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql gd

# Instalar Composer globalmente desde la imagen oficial de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar archivos de Composer y instalar dependencias PHP
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copiar todo el código de la aplicación
COPY . .

# Ajustar permisos para Laravel (storage, bootstrap/cache, etc.)
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Copiar el script de entrada (entrypoint)
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

CMD ["/entrypoint.sh"]