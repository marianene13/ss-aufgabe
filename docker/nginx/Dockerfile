FROM nginx:1.26.1-alpine as base

RUN mkdir /etc/nginx/ssl
COPY docker/nginx/ssl /etc/nginx/ssl
COPY docker/nginx/tmpl.nginx.conf /etc/nginx/

ENV D="$"
ENV PHP_HOST=php
ENV PHP_PATH=/var/www/public
ENV LOG_FORMAT="/dev/stdout json_combined"
CMD ["/bin/sh","-c","envsubst '$$D,$$PHP_HOST,$$PHP_PATH,$$LOG_FORMAT' < /etc/nginx/tmpl.nginx.conf > /etc/nginx/nginx.conf && exec nginx -g 'daemon off;'"]

FROM base as local
