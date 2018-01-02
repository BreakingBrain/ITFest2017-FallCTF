FROM ubuntu:16.04

COPY provision/build.sh build.sh
RUN chmod +x build.sh
RUN ./build.sh

RUN rm /etc/nginx/sites-available/default
COPY nginx/default.conf /etc/nginx/sites-available/default

COPY src /usr/src/browser
RUN chown -R www-data:www-data /usr/src/browser
WORKDIR /usr/src/browser


CMD service mysql start && service php7.0-fpm start && service nginx start && top