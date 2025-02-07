FROM php:8.4-cli

# Establecer el directorio de trabajo
WORKDIR /var/www

# Instalar dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
  git \
  unzip \
  curl \
  libonig-dev \
  netcat-openbsd \
  && rm -rf /var/lib/apt/lists/*

# Instalar la extensión PDO MySQL necesaria para conectar con MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Composer (copiado desde la imagen oficial de Composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar Node.js (utilizando el repositorio de NodeSource para Node.js 18)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
  && apt-get install -y nodejs \
  && rm -rf /var/lib/apt/lists/*

# Copiar los archivos de Composer para cachear dependencias (opcional)
COPY composer.json composer.lock /var/www/
RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

# Copiar el resto de la aplicación, incluyendo .env.example
COPY . /var/www

# Copiar el entrypoint a una ubicación fuera del volumen montado
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exponer el puerto 8000 para la aplicación
EXPOSE 8000

# Comando de inicio
CMD ["/usr/local/bin/entrypoint.sh"]