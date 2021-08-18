FROM php:7.2-apache
COPY . /var/www/html/
WORKDIR /var/www/html/
RUN a2enmod rewrite
RUN apt-get update
RUN docker-php-ext-install mysqli
#CMD [ "php", "./your-script.php" ]