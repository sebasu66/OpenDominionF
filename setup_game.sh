#!/bin/bash
# setup_game.sh - Migra y siembra la base de datos para un nuevo juego
set -e

# Eliminar base de datos SQLite si existe
rm -f database/database.sqlite

# Crear base de datos vacía
touch database/database.sqlite

# Migrar y sembrar
php artisan migrate:fresh --seed
