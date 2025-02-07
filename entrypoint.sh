#!/bin/sh
set -e

# Verifica si no existe el archivo .env, lo copia desde .env.example
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        echo ".env no encontrado. Copiando .env.example a .env..."
        cp .env.example .env
    else
        echo "Error: No se encontró .env ni .env.example."
        exit 1
    fi
fi

# Si no existe el directorio vendor, ejecutar composer install
if [ ! -d vendor ]; then
    echo "No se encontró el directorio vendor. Ejecutando composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

echo "Ejecutando npm install..."
npm install

echo "Ejecutando npm run dev en segundo plano..."
npm run dev &

echo "Creando link simbólico de storage..."
php artisan storage:link

echo "Ejecutando php artisan serve..."
php artisan serve --host=0.0.0.0 --port=8000
