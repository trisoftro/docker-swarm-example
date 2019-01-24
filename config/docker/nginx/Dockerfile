FROM nginx:1.15-alpine-perl

COPY config/docker/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /app/public && mkdir -p /app/var/log
