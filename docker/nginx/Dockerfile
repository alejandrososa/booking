FROM alpine:3.8

LABEL maintainer="Alejandro Sosa <alesjohnson@hotmail.com>"

RUN apk add --update --no-cache nginx

COPY nginx.conf /etc/nginx/
COPY default.conf /etc/nginx/conf.d/

RUN echo "upstream php-upstream { server php:9001; }" > /etc/nginx/conf.d/upstream.conf

RUN adduser -D -g '' -G www-data www-data

WORKDIR /var/www

EXPOSE 80
EXPOSE 443

CMD ["nginx"]