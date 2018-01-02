FROM ubuntu:16.04

RUN apt-get update && apt-get install -y php php-fpm nginx

RUN rm /etc/nginx/sites-available/default
COPY nginx/default.conf /etc/nginx/sites-available/default

COPY src /usr/src/browser
RUN chown -R www-data:www-data /usr/src/browser
WORKDIR /usr/src/browser


CMD service php7.0-fpm start && service nginx start && top
