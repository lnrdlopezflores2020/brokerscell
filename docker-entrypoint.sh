#!/bin/sh

# Configurar Apache para escuchar en el puerto asignado por Render (por defecto 10000 o $PORT)
PORT="${PORT:-80}"
sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Limpiar y optimizar cachés de Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar Apache en primer plano
exec apache2-foreground