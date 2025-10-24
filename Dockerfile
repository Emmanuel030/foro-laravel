# Imagen base de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema (incluyendo SQLite desde fuente oficial)
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    pkg-config libsqlite3-dev sqlite3 \
    && docker-php-ext-configure pdo_sqlite --with-pdo-sqlite=/usr \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Establecer permisos correctos
RUN chmod -R 777 storage bootstrap/cache

# Exponer el puerto
EXPOSE 80

# Comando de inicio
CMD php artisan config:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=80
