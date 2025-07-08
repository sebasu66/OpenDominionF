#!/bin/bash
# start.sh - Inicia el servidor Laravel
set -e

# Puerto por defecto o el que se pase como argumento
PORT=${1:-8000}

# Iniciar servidor Laravel
php artisan serve --host=0.0.0.0 --port=$PORT
