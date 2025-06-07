# Dockerfile para o Sistema de Receitas Apocalípticas
FROM php:8.2-fpm

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Instalar ferramentas adicionais
RUN apt-get update && apt-get install -y \
    curl \
    nano \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos da aplicação
COPY . /var/www/html/

# Instalar dependências do Composer
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copiar configuração PHP customizada
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Expor porta 9000 (PHP-FPM)
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
