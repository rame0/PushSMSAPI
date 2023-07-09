FROM php:7.4-apache

ENV APACHE_DOCUMENT_ROOT /
ENV USER_ID 1000
ENV GROUP_ID 1000
#ENV PHP_IDE_CONFIG Docker

# Prepare
RUN apt-get update \
&& apt-get install -y wget apt-transport-https zlib1g-dev libzip-dev libxml2-dev \
&& docker-php-ext-install zip \
&& docker-php-ext-enable zip \
&& CFLAGS="-I/usr/src/php" docker-php-ext-install xmlreader xmlwriter \
&& docker-php-ext-enable xmlwriter xmlreader


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc


USER "${USER_ID}:${GROUP_ID}"
RUN composer

EXPOSE 80
