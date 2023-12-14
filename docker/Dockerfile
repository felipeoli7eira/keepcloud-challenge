FROM php:8.0-apache

USER root

ARG project=laravelapp
ARG user=laravelapp
ARG uid=1000

RUN apt-get update && apt-get install -y \
  git \
  curl \
  sudo \
  zip \
  unzip \
  libpng-dev \
  libicu-dev \
  libbz2-dev \
  libpng-dev \
  libjpeg-dev \
  libonig-dev \
  libxml2-dev \
  libzip-dev \
  libmcrypt-dev \
  libreadline-dev \
  libfreetype6-dev

RUN docker-php-ext-install pdo_mysql intl mbstring exif pcntl bcmath gd iconv xml zip

RUN apt-get install -y autoconf pkg-config libssl-dev

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get upgrade -y && apt-get install npm -y && npm install

RUN echo "ServerName laravel-app.local" >> /etc/apache2/apache2.conf
COPY ports.conf /etc/apache2/ports.conf
COPY site-default.conf /etc/apache2/sites-enabled/000-default.conf

ENV APACHE_DOCUMENT_ROOT=/$project/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

RUN useradd -m $user && passwd -d $user && usermod -aG sudo $user

USER $user

WORKDIR /$project
