FROM php:7.4-cli

WORKDIR /var/www/test-pb

RUN rm /etc/apt/preferences.d/no-debian-php \
&& apt-get update -y \
&& apt-get install -y git zip unzip gosu \
&& docker-php-ext-install pdo_mysql

ENV COMPOSER_HOME /usr/local/composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
RUN mkdir -p /usr/local/composer \
    && chown www-data:www-data /usr/local/composer \
    && mkdir /var/www/.ssh

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php", "-a"]