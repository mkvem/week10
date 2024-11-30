FROM php:8.3-apache

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# mengubah document_root dari /var/www/html menjadi /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html/
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN a2enmod rewrite
RUN service apache2 restart
RUN docker-php-ext-install mysqli pdo pdo_mysql
# mengubah permission
RUN chown www-data:www-data /var/www/html/ -R
EXPOSE 80

RUN composer install

RUN apt-get update && apt-get install -y \
    software-properties-common \
    npm
RUN npm install npm@latest -g && \
    npm install n -g && \
    n latest
RUN npm run build