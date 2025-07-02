FROM php:8.2-apache

# Instala extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql \
 && apt-get update \
 && apt-get install -y default-mysql-client libpng-dev \
 && docker-php-ext-install gd

# Copia todos os arquivos do projeto (incluindo index.php) para o Apache
COPY . /var/www/html/

# Corrige permissões
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html

# Ativa mod_rewrite (opcional, útil para rotas)
RUN a2enmod rewrite
