#!/bin/sh
set -e

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
