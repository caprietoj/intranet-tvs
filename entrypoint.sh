#!/bin/sh
set -e

# Verificar y copiar el archivo de entorno si no existe
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

# Esperar a que la base de datos esté lista
echo "Esperando a que la base de datos ($DB_HOST:$DB_PORT) esté lista..."
until nc -z $DB_HOST $DB_PORT; do
  echo "Esperando a que MySQL se inicie en $DB_HOST:$DB_PORT..."
  sleep 1
done
echo "La base de datos está lista, continuando..."

# Verificar si el enlace simbólico public/storage existe antes de crearlo
if [ ! -L public/storage ]; then
  echo "Creando link simbólico de storage..."
  php artisan storage:link
else
  echo "El enlace simbólico public/storage ya existe. Omitiendo..."
fi

# Ejecutar comandos adicionales de Artisan
echo "Ejecutando key:generate..."
php artisan key:generate --ansi

echo "Ejecutando migraciones..."
php artisan migrate --force

echo "Ejecutando php artisan serve..."
php artisan serve --host=0.0.0.0 --port=8000