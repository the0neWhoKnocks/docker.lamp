ARG VERSION=""
FROM php:${VERSION:+${VERSION}-}fpm-alpine

RUN \
  apk update \
  && apk upgrade

RUN docker-php-ext-install mysqli
