ARG VERSION=""
FROM httpd:${VERSION:+${VERSION}-}alpine

RUN \
  apk update \
  && apk upgrade

# Copy apache vhost file to proxy php requests to php-fpm container
COPY example-vhost.conf /usr/local/apache2/conf/example-vhost.conf
RUN \
  echo "Include /usr/local/apache2/conf/example-vhost.conf" \
  >> /usr/local/apache2/conf/httpd.conf
