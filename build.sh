#!/bin/bash
# build.sh - Instala dependencias y prepara el entorno
set -e

# Instalar dependencias PHP
if [ -f composer.phar ]; then
    php composer.phar install
elif [ -f composer-2.2.phar ]; then
    php composer-2.2.phar install
else
    composer install
fi

# Instalar dependencias JS si existe package.json
test -f package.json && npm install || true

# Crear archivo de base de datos SQLite si no existe
mkdir -p database
touch database/database.sqlite

# Copiar .env.example si no existe .env
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generar clave de aplicación
php artisan key:generate

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan config:cache
