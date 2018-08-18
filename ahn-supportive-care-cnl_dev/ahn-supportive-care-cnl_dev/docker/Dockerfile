FROM php:5.6-apache


COPY . /srv/app
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/whatever.ini /usr/local/etc/php/conf.d/whatever.ini

RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /srv/app/cnl.com.key -out /srv/app/cnl.crt -subj "/C=MR/ST=PA/L=Pittsburgh/O=IT/OU=Dev/CN=charles-dev.cnl.com"

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN chown -R www-data:www-data /srv/app \
    && a2enmod rewrite && a2enmod ssl && a2enmod headers
