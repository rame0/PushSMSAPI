FROM php:7.4-apache

ENV APACHE_DOCUMENT_ROOT /
ENV USER_ID 1000
ENV GROUP_ID 1000
#ENV PHP_IDE_CONFIG Docker

# Prepare
RUN apt-get update \
&& apt-get install -y wget apt-transport-https \
&& apt-get install -y zip unzip git \
# XDEBUG for debuging
&& pecl install xdebug-3.1.6 \
&& docker-php-ext-enable xdebug \
# JSON
&& docker-php-ext-install -j$(nproc) json \
&& docker-php-ext-enable json \
# ICU
&& apt-get install -y libicu-dev \
# INTL
&& docker-php-ext-install -j$(nproc) intl \
&& docker-php-ext-enable intl \
# XML
&& apt-get install -y libxml2-dev \
&& CFLAGS="-I/usr/src/php" docker-php-ext-install xmlreader xmlwriter \
&& docker-php-ext-enable xmlwriter xmlreader
# ZIP
RUN apt-get install -y zlib1g-dev libzip-dev \
&& docker-php-ext-install zip \
&& docker-php-ext-enable zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc


USER "${USER_ID}:${GROUP_ID}"
RUN composer

EXPOSE 80
