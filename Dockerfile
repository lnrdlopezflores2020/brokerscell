FROM php:8.4-apache

# 1. Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 2. Habilitar mod_rewrite de Apache para el enrutamiento de Laravel
RUN a2enmod rewrite

# 3. Apuntar la raíz de Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# 4. Establecer directorio de trabajo
WORKDIR /var/www/html

# 5. Copiar los archivos del proyecto
COPY . .

# 6. Instalar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Instalar dependencias de producción de Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# 8. Asignar permisos correctos a storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Copiar y preparar el script de inicio
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]