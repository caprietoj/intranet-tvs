#!/bin/sh
set -e

echo "Ejecutando npm install..."
npm install

echo "Ejecutando npm run dev en segundo plano..."
npm run dev &

echo "Creando link simbólico de storage..."
php artisan storage:link

echo "Ejecutando php artisan serve..."
php artisan serve --host=0.0.0.0 --port=8000