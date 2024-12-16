# Usa la imagen oficial de Debian con PHP 8.1 y Apache como base
FROM php:8.1-apache

# Instala las extensiones necesarias para PHP
RUN docker-php-ext-install mysqli pdo_mysql

# Copia el contenido de la carpeta local al directorio raíz de Apache
COPY . /var/www/html/

# Configura Apache para que use index.php como archivo de índice por defecto
RUN sed -i 's/DirectoryIndex index.html/DirectoryIndex index.php index.html/g' /etc/apache2/mods-enabled/dir.conf

# Expone el puerto 80
EXPOSE 80

# Comando para ejecutar Apache en primer plano
CMD ["apachectl", "-D", "FOREGROUND"]
