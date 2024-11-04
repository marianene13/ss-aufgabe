FROM php:8.2-fpm

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

WORKDIR /var/www

# Install required php extensions
RUN install-php-extensions dom pdo_mysql gd zip

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get install -y git nodejs npm

COPY . .

RUN composer install
RUN npm install

COPY ./vendor ./node_modules ./

RUN chmod -R +x /usr/local/bin/
RUN chown -R www-data /var
RUN chmod -R +x /var

